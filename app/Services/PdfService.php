<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\AdministrativeRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Grade;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    /**
     * Generate academic transcript PDF
     *
     * @param Student|AdministrativeRequest $data
     */
    public function generateTranscript($data)
    {
        $student = $data instanceof AdministrativeRequest ? $data->student : $data;
        $grades = Grade::whereHas('module', function($query) use ($student) {
            $query->where('group_id', $student->group_id);
        })->with('module')->get();

        $pdf = PDF::loadView('pdf.transcript', [
            'student' => $student,
            'grades' => $grades,
        ]);

        $filename = 'transcript_' . $student->id . '_' . time() . '.pdf';
        $path = 'documents/' . $filename;
        
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    /**
     * Generate certificate PDF
     *
     * @param Student|AdministrativeRequest $data
     */
    public function generateCertificate($data)
    {
        $student = $data instanceof AdministrativeRequest ? $data->student : $data;

        $pdf = PDF::loadView('pdf.certificate', [
            'student' => $student,
        ]);

        $filename = 'certificate_' . $student->id . '_' . time() . '.pdf';
        $path = 'documents/' . $filename;
        
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    /**
     * Generate attestation PDF
     *
     * @param Student|AdministrativeRequest $data
     */
    public function generateAttestation($data)
    {
        $student = $data instanceof AdministrativeRequest ? $data->student : $data;

        $pdf = PDF::loadView('pdf.attestation', [
            'student' => $student,
        ]);

        $filename = 'attestation_' . $student->id . '_' . time() . '.pdf';
        $path = 'documents/' . $filename;
        
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    /**
     * Generate document based on request type
     */
    public function generateDocument(AdministrativeRequest $request)
    {
        switch ($request->type) {
            case 'transcript':
                return $this->generateTranscript($request);
            case 'certificate':
                return $this->generateCertificate($request);
            case 'attestation':
                return $this->generateAttestation($request);
            case 'work_attestation':
                return $this->generateWorkAttestation($request);
            case 'mission_order':
                return $this->generateMissionOrder($request);
            default:
                throw new \Exception('Unsupported document type');
        }
    }

    public function generateWorkAttestation(AdministrativeRequest $request)
    {
        $teacher = $request->teacher;
        if (!$teacher) {
            throw new \Exception('Teacher not found for request');
        }

        $pdf = PDF::loadView('pdf.work-attestation', [
            'teacher' => $teacher,
            'request' => $request,
        ]);

        $filename = 'work_attestation_' . $teacher->id . '_' . time() . '.pdf';
        $path = 'documents/' . $filename;

        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    public function generateMissionOrder(AdministrativeRequest $request)
    {
        $teacher = $request->teacher;
        if (!$teacher) {
            throw new \Exception('Teacher not found for request');
        }

        $pdf = PDF::loadView('pdf.mission-order', [
            'teacher' => $teacher,
            'request' => $request,
        ]);

        $filename = 'mission_order_' . $teacher->id . '_' . time() . '.pdf';
        $path = 'documents/' . $filename;

        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }
}
