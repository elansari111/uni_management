<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Absence;
use App\Models\AbsenceJustification;
use App\Models\AdministrativeRequest;
use App\Models\GeneratedDocument;
use App\Models\Announcement;
use App\Models\CourseMaterial;
use App\Models\Schedule;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Get student profile or redirect.
     */
    protected function getStudent()
    {
        $student = auth()->user()->student;
        if (!$student) {
            abort(403, 'Student profile not found.');
        }
        return $student;
    }

    /**
     * Dashboard.
     */
    public function dashboard()
    {
        $student = $this->getStudent();

        $absencesCount = Absence::where('student_id', $student->id)->count();
        $excusedCount = Absence::where('student_id', $student->id)->where('status', 'justified')->count();
        $unexcusedCount = $absencesCount - $excusedCount;

        $gradesCount = Grade::where('student_id', $student->id)->whereNotNull('final_grade')->count();
        $gpa = 0;
        if ($gradesCount > 0) {
            $gpa = Grade::where('student_id', $student->id)->whereNotNull('final_grade')->avg('final_grade');
        }

        // Recent grades
        $recentGrades = Grade::where('student_id', $student->id)->with('module')->latest()->take(5)->get();

        // Recent announcements
        $announcements = Announcement::with('creator')->latest()->take(5)->get();

        return view('student.dashboard', compact('absencesCount', 'unexcusedCount', 'gpa', 'recentGrades', 'announcements'));
    }

    /**
     * Grades page.
     */
    public function grades()
    {
        $student = $this->getStudent();
        $grades = Grade::where('student_id', $student->id)->with('module.teacher')->get();
        return view('student.grades.index', compact('grades'));
    }

    /**
     * Absences index & submit justification.
     */
    public function absences()
    {
        $student = $this->getStudent();
        $absences = Absence::where('student_id', $student->id)->with('module')->latest()->get();
        return view('student.absences.index', compact('absences'));
    }

    public function submitJustification(Request $request)
    {
        $request->validate([
            'absence_id' => 'required|exists:absences,id',
            'reason' => 'required|string',
            'document' => 'required|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        $absence = Absence::findOrFail($request->absence_id);
        $student = $this->getStudent();

        if ($absence->student_id !== $student->id) {
            abort(403, 'Unauthorized.');
        }

        // Upload justification document
        $path = $request->file('document')->store('justifications', 'public');

        // Create the justification record (linked via student_id)
        $justification = AbsenceJustification::create([
            'student_id'    => $student->id,
            'reason'        => $request->reason,
            'document_path' => $path,
            'status'        => 'pending',
        ]);

        // Link the absence to this justification and mark it as pending
        $absence->update([
            'justification_id' => $justification->id,
            'status'           => 'pending',
        ]);

        return back()->with('success', 'Justification submitted successfully.');
    }

    /**
     * Administrative requests & generated documents.
     */
    public function requests()
    {
        $student = $this->getStudent();
        $requests = AdministrativeRequest::where('student_id', $student->id)->latest()->get();
        $documents = GeneratedDocument::where('student_id', $student->id)->with('request')->latest()->get();

        return view('student.requests.index', compact('requests', 'documents'));
    }

    public function submitRequest(Request $request)
    {
        $student = $this->getStudent();

        $request->validate([
            'request_type' => 'required|in:transcript,certificate,attestation,other',
            'purpose' => 'required|string|max:500',
        ]);

        AdministrativeRequest::create([
            'student_id'   => $student->id,
            'type'         => $request->request_type,
            'title'        => ucfirst($request->request_type) . ' Request',
            'description'  => $request->purpose,
            'status'       => 'pending',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Administrative request submitted.');
    }
}
