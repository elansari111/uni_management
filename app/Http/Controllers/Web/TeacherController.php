<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Absence;
use App\Models\Schedule;
use App\Models\LessonLog;
use App\Models\Classroom;
use App\Models\RoomReservation;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\CourseMaterial;
use App\Models\AdministrativeRequest;
use App\Models\GeneratedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Teacher Dashboard.
     */
    public function dashboard()
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return redirect('/login')->with('error', 'Teacher profile not found.');
        }

        $modulesCount = Module::where('teacher_id', Auth::id())->count();
        $logsCount = LessonLog::where('teacher_id', $teacher->id)->count();
        $reservationsCount = RoomReservation::where('user_id', Auth::id())->count();

        $recentLogs = LessonLog::where('teacher_id', $teacher->id)->with(['module', 'classroom'])->latest()->take(5)->get();
        $recentReservations = RoomReservation::where('user_id', Auth::id())->with('classroom')->latest()->take(5)->get();

        return view('teacher.dashboard', compact('modulesCount', 'logsCount', 'reservationsCount', 'recentLogs', 'recentReservations'));
    }

    /**
     * List modules.
     */
    public function modules()
    {
        $modules = Module::where('teacher_id', Auth::id())->with(['group', 'schedules.classroom'])->get();
        return view('teacher.modules.index', compact('modules'));
    }

    public function schedule()
    {
        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi',
        ];

        $schedules = Schedule::with(['module.group', 'classroom'])
            ->whereHas('module', function ($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->orderByRaw("FIELD(day_of_week,'monday','tuesday','wednesday','thursday','friday','saturday')")
            ->orderBy('start_time')
            ->get();

        $schedulesByDay = $schedules->groupBy('day_of_week');

        return view('teacher.schedule.index', compact('days', 'schedulesByDay'));
    }

    public function classroom(int $moduleId)
    {
        $module = Module::where('teacher_id', Auth::id())
            ->with('group')
            ->findOrFail($moduleId);

        $announcements = Announcement::where('module_id', $module->id)
            ->with(['creator', 'comments.user'])
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->get();

        $materials = CourseMaterial::where('module_id', $module->id)
            ->with('uploader')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        return view('teacher.classroom.show', compact('module', 'announcements', 'materials'));
    }

    public function storeAnnouncement(Request $request, int $moduleId)
    {
        $module = Module::where('teacher_id', Auth::id())->findOrFail($moduleId);

        $data = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:3|max:5000',
            'is_pinned' => 'nullable|boolean',
        ]);

        Announcement::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'module_id' => $module->id,
            'target_role' => 'student',
            'created_by' => Auth::id(),
            'published_at' => now(),
            'is_pinned' => (bool) ($data['is_pinned'] ?? false),
            'status' => 'published',
        ]);

        return back()->with('success', 'Annonce publiée.');
    }

    public function storeCourseMaterial(Request $request, int $moduleId)
    {
        $module = Module::where('teacher_id', Auth::id())->findOrFail($moduleId);

        $data = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:2000',
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar,jpg,jpeg,png',
        ]);

        $file = $request->file('file');
        $path = $file->store('materials/' . $module->id, 'public');

        CourseMaterial::create([
            'module_id' => $module->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'file_path' => $path,
            'file_type' => strtolower($file->getClientOriginalExtension()),
            'file_size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Support ajouté.');
    }

    public function storeAnnouncementComment(Request $request, int $announcementId)
    {
        $announcement = Announcement::with('module')->findOrFail($announcementId);

        $isTeacherOfModule = $announcement->module && $announcement->module->teacher_id === Auth::id();
        if (!$isTeacherOfModule) {
            abort(403);
        }

        $data = $request->validate([
            'content' => 'required|string|min:1|max:2000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'content' => $data['content'],
            'commentable_type' => Announcement::class,
            'commentable_id' => $announcement->id,
            'status' => 'approved',
        ]);

        return back()->with('success', 'Commentaire ajouté.');
    }

    public function requestsIndex()
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            abort(403);
        }

        $requests = AdministrativeRequest::where('teacher_id', $teacher->id)->latest()->get();
        $documents = GeneratedDocument::where('teacher_id', $teacher->id)->latest()->get();

        return view('teacher.requests.index', compact('requests', 'documents'));
    }

    public function submitRequest(Request $request)
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            abort(403);
        }

        $data = $request->validate([
            'type' => 'required|in:work_attestation,mission_order',
            'destination' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'purpose' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:2000',
        ]);

        if ($data['type'] === 'mission_order') {
            $request->validate([
                'destination' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'purpose' => 'required|string|max:500',
            ]);
        }

        $title = $data['type'] === 'work_attestation'
            ? 'Attestation de travail'
            : 'Ordre de mission';

        AdministrativeRequest::create([
            'student_id' => null,
            'teacher_id' => $teacher->id,
            'type' => $data['type'],
            'title' => $title,
            'description' => $data['description'] ?? ($data['purpose'] ?? ''),
            'destination' => $data['destination'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'purpose' => $data['purpose'] ?? null,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Demande envoyée.');
    }

    /**
     * Grading interface.
     */
    public function gradesIndex(Request $request)
    {
        $modules = Module::where('teacher_id', Auth::id())->get();
        $selectedModule = null;
        $students = collect();

        if ($request->filled('module_id')) {
            $selectedModule = Module::where('teacher_id', Auth::id())->with('group.students.user')->findOrFail($request->module_id);
            if ($selectedModule->group) {
                $students = $selectedModule->group->students;
                // Load existing grades for this module
                foreach ($students as $student) {
                    $student->grade = Grade::where('student_id', $student->id)
                        ->where('module_id', $selectedModule->id)
                        ->first();
                }
            }
        }

        return view('teacher.grades.index', compact('modules', 'selectedModule', 'students'));
    }

    /**
     * Store/update grade.
     */
    public function storeGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'module_id' => 'required|exists:modules,id',
            'cc1' => 'nullable|numeric|min:0|max:20',
            'cc2' => 'nullable|numeric|min:0|max:20',
            'exam' => 'nullable|numeric|min:0|max:20',
            'remarks' => 'nullable|string',
        ]);

        $cc1 = $request->cc1;
        $cc2 = $request->cc2;
        $exam = $request->exam;

        // Calculate final grade if fields are provided
        // Formula: Final Grade = ((CC1 + CC2) / 2) * 0.4 + Exam * 0.6
        $finalGrade = null;
        if ($cc1 !== null && $cc2 !== null && $exam !== null) {
            $finalGrade = (($cc1 + $cc2) / 2) * 0.4 + $exam * 0.6;
        }

        Grade::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'module_id' => $request->module_id,
            ],
            [
                'cc1' => $cc1,
                'cc2' => $cc2,
                'exam' => $exam,
                'final_grade' => $finalGrade,
                'remarks' => $request->remarks,
            ]
        );

        return back()->with('success', 'Grade saved successfully.');
    }

    /**
     * Attendance tracking.
     */
    public function attendanceIndex(Request $request)
    {
        $modules = Module::where('teacher_id', Auth::id())->get();
        $selectedModule = null;
        $students = collect();
        $date = $request->input('date', date('Y-m-d'));

        if ($request->filled('module_id')) {
            $selectedModule = Module::where('teacher_id', Auth::id())->with('group.students.user')->findOrFail($request->module_id);
            if ($selectedModule->group) {
                $students = $selectedModule->group->students;
                // Get absences for this date & module
                $absences = Absence::where('module_id', $selectedModule->id)
                    ->whereDate('date', $date)
                    ->get()
                    ->keyBy('student_id');

                foreach ($students as $student) {
                    $student->is_absent = isset($absences[$student->id]);
                    $student->absence_type = $student->is_absent ? $absences[$student->id]->type : null;
                }
            }
        }

        return view('teacher.attendance.index', compact('modules', 'selectedModule', 'students', 'date'));
    }

    /**
     * Bulk store attendance.
     */
    public function storeAttendance(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'date' => 'required|date',
            'absences' => 'nullable|array',
            'absences.*' => 'exists:students,id',
        ]);

        $moduleId = $request->module_id;
        $date = $request->date;
        $absentStudentIds = $request->input('absences', []);

        $module = Module::findOrFail($moduleId);
        if (!$module->group) {
            return back()->with('error', 'Module has no group associated.');
        }

        $allStudents = $module->group->students;

        foreach ($allStudents as $student) {
            $isAbsent = in_array($student->id, $absentStudentIds);

            if ($isAbsent) {
                Absence::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'module_id' => $moduleId,
                        'date' => $date,
                    ],
                    [
                        'type' => 'absent',
                        'status' => 'unjustified',
                    ]
                );
            } else {
                // Delete if presence is recorded now
                Absence::where('student_id', $student->id)
                    ->where('module_id', $moduleId)
                    ->whereDate('date', $date)
                    ->delete();
            }
        }

        return back()->with('success', 'Attendance sheets saved successfully.');
    }

    /**
     * Lesson logs CRUD.
     */
    public function lessonLogsIndex()
    {
        $teacher = Auth::user()->teacher;
        $logs = LessonLog::where('teacher_id', $teacher->id)->with(['module', 'classroom'])->latest()->paginate(15);
        $modules = Module::where('teacher_id', Auth::id())->get();
        $classrooms = Classroom::all();

        return view('teacher.lesson-logs.index', compact('logs', 'modules', 'classrooms'));
    }

    public function storeLessonLog(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
        ]);

        LessonLog::create(array_merge($request->all(), ['teacher_id' => $teacher->id]));

        return back()->with('success', 'Lesson log saved.');
    }

    /**
     * Room reservations.
     */
    public function roomReservationsIndex()
    {
        $reservations = RoomReservation::where('user_id', Auth::id())->with('classroom')->latest()->paginate(15);
        $classrooms = Classroom::where('status', 'available')->get();

        return view('teacher.reservations.index', compact('reservations', 'classrooms'));
    }

    public function storeRoomReservation(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'purpose' => 'required|string',
        ]);

        RoomReservation::create([
            'user_id' => Auth::id(),
            'classroom_id' => $request->classroom_id,
            'reservation_date' => $request->reservation_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Room reservation request submitted.');
    }
}
