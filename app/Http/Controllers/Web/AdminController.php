<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\Level;
use App\Models\Module;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\RoomReservation;
use App\Models\AdministrativeRequest;
use App\Models\AbsenceJustification;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\LessonLog;
use App\Services\ScheduleConflictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'approved_by' => Auth::id(),
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
            'approved_by' => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Room reservation rejected successfully.');
    }

    /**
     * Administrative document requests.
     */
    public function administrativeRequests()
    {
        $requests = AdministrativeRequest::with(['student.user', 'teacher.user'])->orderBy('created_at', 'desc')->paginate(15);
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
            $adminRequest->update([
                'status' => 'approved',
                'processed_at' => now(),
                'processed_by' => Auth::id(),
                'admin_notes' => null,
            ]);

            try {
                $pdfService = app(\App\Services\PdfService::class);
                $pdfPath = $pdfService->generateDocument($adminRequest);

                if ($pdfPath) {
                    $student = $adminRequest->student;
                    $teacher = $adminRequest->teacher;
                    $ownerName = $student?->user?->name ?? $teacher?->user?->name ?? 'Utilisateur';

                    \App\Models\GeneratedDocument::create([
                        'student_id' => $student?->id,
                        'teacher_id' => $teacher?->id,
                        'request_id' => $adminRequest->id,
                        'type' => $adminRequest->type,
                        'title' => ucfirst(str_replace('_', ' ', $adminRequest->type)) . ' - ' . $ownerName,
                        'file_path' => $pdfPath,
                        'file_type' => 'pdf',
                        'generated_by' => Auth::id(),
                        'generated_at' => now(),
                        'is_official' => true,
                    ]);
                }
            } catch (\Exception) {
            }

            return back()->with('success', 'Request approved successfully.');
        } else {
            $adminRequest->update([
                'status' => 'rejected',
                'processed_at' => now(),
                'processed_by' => Auth::id(),
                'admin_notes' => $request->rejection_reason,
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
            'reviewed_by'  => Auth::id(),
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

    public function schedulesEdit(int $id)
    {
        $schedule = Schedule::with(['module', 'classroom'])->findOrFail($id);
        $modules = Module::with(['teacher', 'group'])->get();
        $classrooms = Classroom::where('status', 'available')->get();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        return view('admin.schedules.edit', compact('schedule', 'modules', 'classrooms', 'days'));
    }

    public function schedulesUpdate(Request $request, int $id)
    {
        $schedule = Schedule::findOrFail($id);

        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'type' => 'required|in:lecture,tutorial,practical,exam',
        ]);

        $conflicts = $this->conflictService->checkConflicts($data, $schedule->id);

        if (!empty($conflicts)) {
            $messages = collect($conflicts)->pluck('message')->join('; ');
            return back()->withErrors(['conflict' => 'Schedule conflict detected: ' . $messages])->withInput();
        }

        $schedule->update($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule entry updated successfully.');
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

    public function levelsIndex()
    {
        $levels = Level::orderBy('order')->orderBy('name')->paginate(15);
        return view('admin.levels.index', compact('levels'));
    }

    public function levelsCreate()
    {
        return view('admin.levels.create');
    }

    public function levelsStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:levels,name',
            'code' => 'required|string|max:50|unique:levels,code',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $data['order'] = $data['order'] ?? 0;

        Level::create($data);

        return redirect()->route('admin.levels.index')->with('success', 'Niveau créé avec succès.');
    }

    public function levelsEdit(int $id)
    {
        $level = Level::findOrFail($id);
        return view('admin.levels.edit', compact('level'));
    }

    public function levelsUpdate(Request $request, int $id)
    {
        $level = Level::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:levels,name,' . $level->id,
            'code' => 'required|string|max:50|unique:levels,code,' . $level->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $data['order'] = $data['order'] ?? 0;

        $level->update($data);

        return redirect()->route('admin.levels.index')->with('success', 'Niveau mis à jour avec succès.');
    }

    public function levelsDestroy(int $id)
    {
        $level = Level::findOrFail($id);
        $level->delete();

        return redirect()->route('admin.levels.index')->with('success', 'Niveau supprimé avec succès.');
    }

    public function groupsIndex()
    {
        $groups = Group::with('level')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.groups.index', compact('groups'));
    }

    public function groupsCreate()
    {
        $levels = Level::orderBy('order')->orderBy('name')->get();
        return view('admin.groups.create', compact('levels'));
    }

    public function groupsStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:groups,name',
            'code' => 'required|string|max:50|unique:groups,code',
            'description' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
            'level_id' => 'nullable|exists:levels,id',
        ]);

        $data['capacity'] = $data['capacity'] ?? 30;

        Group::create($data);

        return redirect()->route('admin.groups.index')->with('success', 'Groupe créé avec succès.');
    }

    public function groupsEdit(int $id)
    {
        $group = Group::findOrFail($id);
        $levels = Level::orderBy('order')->orderBy('name')->get();
        return view('admin.groups.edit', compact('group', 'levels'));
    }

    public function groupsUpdate(Request $request, int $id)
    {
        $group = Group::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:groups,name,' . $group->id,
            'code' => 'required|string|max:50|unique:groups,code,' . $group->id,
            'description' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
            'level_id' => 'nullable|exists:levels,id',
        ]);

        $data['capacity'] = $data['capacity'] ?? 30;

        $group->update($data);

        return redirect()->route('admin.groups.index')->with('success', 'Groupe mis à jour avec succès.');
    }

    public function groupsDestroy(int $id)
    {
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->route('admin.groups.index')->with('success', 'Groupe supprimé avec succès.');
    }

    public function classroomsIndex()
    {
        $classrooms = Classroom::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function classroomsCreate()
    {
        $statuses = ['available', 'maintenance', 'unavailable'];
        return view('admin.classrooms.create', compact('statuses'));
    }

    public function classroomsStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:classrooms,code',
            'capacity' => 'nullable|integer|min:1',
            'building' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'equipment' => 'nullable|string',
            'status' => 'required|in:available,maintenance,unavailable',
        ]);

        $data['capacity'] = $data['capacity'] ?? 30;
        $data['equipment'] = $request->filled('equipment')
            ? array_values(array_filter(array_map('trim', explode(',', $request->equipment))))
            : null;

        Classroom::create($data);

        return redirect()->route('admin.classrooms.index')->with('success', 'Salle créée avec succès.');
    }

    public function classroomsEdit(int $id)
    {
        $classroom = Classroom::findOrFail($id);
        $statuses = ['available', 'maintenance', 'unavailable'];
        return view('admin.classrooms.edit', compact('classroom', 'statuses'));
    }

    public function classroomsUpdate(Request $request, int $id)
    {
        $classroom = Classroom::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:classrooms,code,' . $classroom->id,
            'capacity' => 'nullable|integer|min:1',
            'building' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'equipment' => 'nullable|string',
            'status' => 'required|in:available,maintenance,unavailable',
        ]);

        $data['capacity'] = $data['capacity'] ?? 30;
        $data['equipment'] = $request->filled('equipment')
            ? array_values(array_filter(array_map('trim', explode(',', $request->equipment))))
            : null;

        $classroom->update($data);

        return redirect()->route('admin.classrooms.index')->with('success', 'Salle mise à jour avec succès.');
    }

    public function classroomsDestroy(int $id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->route('admin.classrooms.index')->with('success', 'Salle supprimée avec succès.');
    }

    public function lessonLogsIndex()
    {
        $logs = LessonLog::with(['teacher.user', 'module', 'classroom'])
            ->orderByDesc('date')
            ->orderByDesc('start_time')
            ->paginate(15);

        return view('admin.lesson-logs.index', compact('logs'));
    }
}
