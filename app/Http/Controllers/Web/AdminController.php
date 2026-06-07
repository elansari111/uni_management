<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\Module;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\RoomReservation;
use App\Models\AdministrativeRequest;
use App\Models\AbsenceJustification;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\ScheduleConflictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    protected ScheduleConflictService $conflictService;

    public function __construct(ScheduleConflictService $conflictService)
    {
        $this->conflictService = $conflictService;
    }

    /**
     * Dashboard overview.
     */
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'modules' => Module::count(),
            'classrooms' => Classroom::count(),
            'groups' => Group::count(),
            'pending_reservations' => RoomReservation::where('status', 'pending')->count(),
            'pending_requests' => AdministrativeRequest::where('status', 'pending')->count(),
            'pending_absences' => AbsenceJustification::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Users listing.
     */
    public function usersIndex(Request $request)
    {
        $query = User::with(['role', 'student.group', 'teacher']);

        if ($request->filled('role')) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('slug', $request->role);
            });
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * User creation form.
     */
    public function usersCreate()
    {
        $roles = Role::all();
        $groups = Group::all();
        return view('admin.users.create', compact('roles', 'groups'));
    }

    /**
     * Store new user.
     */
    public function usersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'group_id' => 'nullable|required_if:role_slug,student|exists:groups,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'phone' => $request->phone,
        ]);

        $role = Role::find($request->role_id);
        $nameParts = explode(' ', $request->name, 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        if ($role->slug === 'student') {
            $user->student()->create([
                'group_id' => $request->group_id,
                'student_number' => 'STU-' . strtoupper(Str::random(6)),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'enrollment_date' => now(),
            ]);
        } elseif ($role->slug === 'teacher') {
            $user->teacher()->create([
                'employee_number' => 'T-' . strtoupper(Str::random(6)),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'specialization' => 'General',
                'hire_date' => now(),
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * User edit form.
     */
    public function usersEdit(int $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $groups = Group::all();
        return view('admin.users.edit', compact('user', 'roles', 'groups'));
    }

    /**
     * Update user.
     */
    public function usersUpdate(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // Update profiles if name/role changes
        $nameParts = explode(' ', $request->name, 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        $role = Role::find($request->role_id);
        if ($role->slug === 'student') {
            if (!$user->student) {
                $user->student()->create([
                    'group_id' => $request->group_id,
                    'student_number' => 'STU-' . strtoupper(Str::random(6)),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'enrollment_date' => now(),
                ]);
            } else {
                $user->student->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'group_id' => $request->group_id,
                ]);
            }
        } elseif ($role->slug === 'teacher') {
            if (!$user->teacher) {
                $user->teacher()->create([
                    'employee_number' => 'T-' . strtoupper(Str::random(6)),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'specialization' => 'General',
                    'hire_date' => now(),
                ]);
            } else {
                $user->teacher->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ]);
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Delete user.
     */
    public function usersDestroy(int $id)
    {
        $user = User::findOrFail($id);
        if ($user->student) $user->student->delete();
        if ($user->teacher) $user->teacher->delete();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Room reservations lists & validation.
     */
    public function roomReservations()
    {
        $reservations = RoomReservation::with(['user', 'classroom'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.requests.reservations', compact('reservations'));
    }

    public function approveReservation(int $id)
    {
        $reservation = RoomReservation::findOrFail($id);
        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Can only approve pending reservations.');
        }

        $reservation->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Room reservation approved successfully.');
    }

    public function rejectReservation(Request $request, int $id)
    {
        $reservation = RoomReservation::findOrFail($id);
        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Can only reject pending reservations.');
        }

        $request->validate(['rejection_reason' => 'required|string']);

        $reservation->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Room reservation rejected successfully.');
    }

    /**
     * Administrative document requests.
     */
    public function administrativeRequests()
    {
        $requests = AdministrativeRequest::with(['student.user'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.requests.documents', compact('requests'));
    }

    public function validateRequest(Request $request, int $id)
    {
        $adminRequest = AdministrativeRequest::findOrFail($id);
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        if ($request->status === 'approved') {
            // Generates PDF or marks as validated
            $adminRequest->update([
                'status' => 'approved',
                'processed_at' => now(),
            ]);

            // Try to generate documents if student is linked
            try {
                $student = $adminRequest->student;
                if ($student) {
                    $pdfService = app(\App\Services\PdfService::class);
                    $documentType = $adminRequest->type; // e.g., 'certificate', 'transcript'
                    $pdfPath = null;
                    if ($documentType === 'certificate') {
                        $pdfPath = $pdfService->generateCertificate($student);
                    } elseif ($documentType === 'transcript') {
                        $pdfPath = $pdfService->generateTranscript($student);
                    } elseif ($documentType === 'attestation') {
                        $pdfPath = $pdfService->generateAttestation($student);
                    }

                    if ($pdfPath) {
                        \App\Models\GeneratedDocument::create([
                            'student_id' => $student->id,
                            'request_id' => $adminRequest->id,
                            'type' => $documentType,
                            'title' => ucfirst($documentType) . ' for ' . $student->user->name,
                            'file_path' => $pdfPath,
                            'file_type' => 'pdf',
                            'generated_by' => auth()->id(),
                            'generated_at' => now(),
                            'is_official' => true,
                        ]);
                    }
                }
            } catch (\Exception) {
                // Keep the status as approved even if PDF generation failed due to setup
            }

            return back()->with('success', 'Request approved successfully.');
        } else {
            $adminRequest->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'processed_at' => now(),
            ]);

            return back()->with('success', 'Request rejected successfully.');
        }
    }

    /**
     * Absence Justifications validation.
     */
    public function absenceJustifications()
    {
        $justifications = AbsenceJustification::with(['absence.student.user'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.requests.absences', compact('justifications'));
    }

    public function validateAbsence(Request $request, int $id)
    {
        $justification = AbsenceJustification::findOrFail($id);
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        $justification->update([
            'status'       => $request->status,
            'review_notes' => $request->status === 'rejected' ? $request->rejection_reason : null,
            'reviewed_by'  => auth()->id(),
            'reviewed_at'  => now(),
        ]);

        if ($request->status === 'approved' && $justification->absence) {
            $justification->absence->update(['status' => 'justified']);
        }

        return back()->with('success', 'Absence justification processed.');
    }

    /**
     * Schedules management.
     */
    public function schedulesIndex()
    {
        $schedules = Schedule::with(['module.teacher', 'module.group', 'classroom'])->orderBy('day_of_week')->orderBy('start_time')->get();
        $classrooms = Classroom::all();
        $groups = Group::all();
        $modules = Module::all();

        return view('admin.schedules.index', compact('schedules', 'classrooms', 'groups', 'modules'));
    }

    public function schedulesCreate()
    {
        $classrooms = Classroom::where('status', 'available')->get();
        $modules = Module::with(['teacher', 'group'])->where('status', 'active')->get();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        return view('admin.schedules.create', compact('classrooms', 'modules', 'days'));
    }

    public function schedulesStore(Request $request)
    {
        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'type' => 'required|in:lecture,tutorial,practical,exam',
        ]);

        // Check conflict
        $conflicts = $this->conflictService->checkConflicts($data);

        if (!empty($conflicts)) {
            $messages = collect($conflicts)->pluck('message')->join('; ');
            return back()->withErrors(['conflict' => 'Schedule conflict detected: ' . $messages])->withInput();
        }

        Schedule::create($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule entry created successfully.');
    }

    public function schedulesDestroy(int $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule entry removed.');
    }

    /**
     * Modules management.
     */
    public function modulesIndex()
    {
        $modules = Module::with(['teacher', 'group'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.modules.index', compact('modules'));
    }

    public function modulesCreate()
    {
        $teachers = User::whereHas('role', function($q) {
            $q->where('slug', 'teacher');
        })->with('teacher')->get();
        $groups = Group::with('level')->get();
        $levels = ['L1', 'L2', 'L3', 'M1', 'M2'];
        $semesters = ['S1', 'S2'];
        return view('admin.modules.create', compact('teachers', 'groups', 'levels', 'semesters'));
    }

    public function modulesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:modules',
            'description' => 'nullable|string',
            'credits' => 'nullable|integer|min:0',
            'teacher_id' => 'nullable|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
            'level' => 'nullable|in:L1,L2,L3,M1,M2',
            'semester' => 'nullable|in:S1,S2',
            'status' => 'required|in:active,inactive,archived',
        ]);

        Module::create($request->all());

        return redirect()->route('admin.modules.index')->with('success', 'Module created successfully.');
    }

    public function modulesEdit(int $id)
    {
        $module = Module::findOrFail($id);
        $teachers = User::whereHas('role', function($q) {
            $q->where('slug', 'teacher');
        })->with('teacher')->get();
        $groups = Group::with('level')->get();
        $levels = ['L1', 'L2', 'L3', 'M1', 'M2'];
        $semesters = ['S1', 'S2'];
        return view('admin.modules.edit', compact('module', 'teachers', 'groups', 'levels', 'semesters'));
    }

    public function modulesUpdate(Request $request, int $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:modules,code,' . $module->id,
            'description' => 'nullable|string',
            'credits' => 'nullable|integer|min:0',
            'teacher_id' => 'nullable|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
            'level' => 'nullable|in:L1,L2,L3,M1,M2',
            'semester' => 'nullable|in:S1,S2',
            'status' => 'required|in:active,inactive,archived',
        ]);

        $module->update($request->all());

        return redirect()->route('admin.modules.index')->with('success', 'Module updated successfully.');
    }

    public function modulesDestroy(int $id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return redirect()->route('admin.modules.index')->with('success', 'Module deleted successfully.');
    }
}
