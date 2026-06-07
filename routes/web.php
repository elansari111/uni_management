<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\TeacherController;
use App\Http\Controllers\Web\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

// Redirect authenticated users based on role
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->hasRole('student')) {
            return redirect()->route('student.dashboard');
        }
        return view('welcome');
    })->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('users.create');
    Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'usersUpdate'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
    
    // Modules
    Route::get('/modules', [AdminController::class, 'modulesIndex'])->name('modules.index');
    Route::get('/modules/create', [AdminController::class, 'modulesCreate'])->name('modules.create');
    Route::post('/modules', [AdminController::class, 'modulesStore'])->name('modules.store');
    Route::get('/modules/{id}/edit', [AdminController::class, 'modulesEdit'])->name('modules.edit');
    Route::put('/modules/{id}', [AdminController::class, 'modulesUpdate'])->name('modules.update');
    Route::delete('/modules/{id}', [AdminController::class, 'modulesDestroy'])->name('modules.destroy');

    Route::get('/levels', [AdminController::class, 'levelsIndex'])->name('levels.index');
    Route::get('/levels/create', [AdminController::class, 'levelsCreate'])->name('levels.create');
    Route::post('/levels', [AdminController::class, 'levelsStore'])->name('levels.store');
    Route::get('/levels/{id}/edit', [AdminController::class, 'levelsEdit'])->name('levels.edit');
    Route::put('/levels/{id}', [AdminController::class, 'levelsUpdate'])->name('levels.update');
    Route::delete('/levels/{id}', [AdminController::class, 'levelsDestroy'])->name('levels.destroy');

    Route::get('/groups', [AdminController::class, 'groupsIndex'])->name('groups.index');
    Route::get('/groups/create', [AdminController::class, 'groupsCreate'])->name('groups.create');
    Route::post('/groups', [AdminController::class, 'groupsStore'])->name('groups.store');
    Route::get('/groups/{id}/edit', [AdminController::class, 'groupsEdit'])->name('groups.edit');
    Route::put('/groups/{id}', [AdminController::class, 'groupsUpdate'])->name('groups.update');
    Route::delete('/groups/{id}', [AdminController::class, 'groupsDestroy'])->name('groups.destroy');

    Route::get('/classrooms', [AdminController::class, 'classroomsIndex'])->name('classrooms.index');
    Route::get('/classrooms/create', [AdminController::class, 'classroomsCreate'])->name('classrooms.create');
    Route::post('/classrooms', [AdminController::class, 'classroomsStore'])->name('classrooms.store');
    Route::get('/classrooms/{id}/edit', [AdminController::class, 'classroomsEdit'])->name('classrooms.edit');
    Route::put('/classrooms/{id}', [AdminController::class, 'classroomsUpdate'])->name('classrooms.update');
    Route::delete('/classrooms/{id}', [AdminController::class, 'classroomsDestroy'])->name('classrooms.destroy');
    
    // Schedules
    Route::get('/schedules', [AdminController::class, 'schedulesIndex'])->name('schedules.index');
    Route::get('/schedules/create', [AdminController::class, 'schedulesCreate'])->name('schedules.create');
    Route::post('/schedules', [AdminController::class, 'schedulesStore'])->name('schedules.store');
    Route::delete('/schedules/{id}', [AdminController::class, 'schedulesDestroy'])->name('schedules.destroy');

    Route::get('/lesson-logs', [AdminController::class, 'lessonLogsIndex'])->name('lesson-logs.index');
    
    // Room Reservations
    Route::get('/requests/reservations', [AdminController::class, 'roomReservations'])->name('requests.reservations');
    Route::get('/reservations', [AdminController::class, 'roomReservations'])->name('reservations');
    Route::get('/reservations/index', [AdminController::class, 'roomReservations'])->name('reservations.index');
    Route::post('/reservations/{id}/approve', [AdminController::class, 'approveReservation'])->name('reservations.approve');
    Route::post('/reservations/{id}/reject', [AdminController::class, 'rejectReservation'])->name('reservations.reject');
    
    // Administrative Requests
    Route::get('/requests', function () {
        return redirect()->route('admin.requests.documents');
    })->name('requests.index');
    Route::get('/requests/documents', [AdminController::class, 'administrativeRequests'])->name('requests.documents');
    Route::post('/requests/documents/{id}/validate', [AdminController::class, 'validateRequest'])->name('requests.validate');
    Route::post('/requests/{id}/validate', [AdminController::class, 'validateRequest'])->name('requests.validate.old');
    
    // Absence Justifications
    Route::get('/requests/absences', [AdminController::class, 'absenceJustifications'])->name('requests.absences');
    Route::post('/requests/absences/{id}/validate', [AdminController::class, 'validateAbsence'])->name('requests.absences.validate');
    Route::post('/absences/{id}/validate', [AdminController::class, 'validateAbsence'])->name('absences.validate');
});

// Teacher Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/modules', [TeacherController::class, 'modules'])->name('modules');
    Route::get('/schedule', [TeacherController::class, 'schedule'])->name('schedule');
    Route::get('/modules/{id}/classroom', [TeacherController::class, 'classroom'])->name('classroom.show');
    Route::post('/modules/{id}/announcements', [TeacherController::class, 'storeAnnouncement'])->name('classroom.announcements.store');
    Route::post('/modules/{id}/materials', [TeacherController::class, 'storeCourseMaterial'])->name('classroom.materials.store');
    Route::post('/announcements/{id}/comments', [TeacherController::class, 'storeAnnouncementComment'])->name('announcements.comments.store');
    Route::get('/grades', [TeacherController::class, 'gradesIndex'])->name('grades.index');
    Route::post('/grades', [TeacherController::class, 'storeGrade'])->name('grades.store');
    Route::get('/attendance', [TeacherController::class, 'attendanceIndex'])->name('attendance.index');
    Route::post('/attendance', [TeacherController::class, 'storeAttendance'])->name('attendance.store');
    Route::get('/lesson-logs', [TeacherController::class, 'lessonLogsIndex'])->name('lesson-logs.index');
    Route::post('/lesson-logs', [TeacherController::class, 'storeLessonLog'])->name('lesson-logs.store');
    Route::get('/reservations', [TeacherController::class, 'roomReservationsIndex'])->name('reservations.index');
    Route::post('/reservations', [TeacherController::class, 'storeRoomReservation'])->name('reservations.store');
    Route::get('/requests', [TeacherController::class, 'requestsIndex'])->name('requests.index');
    Route::post('/requests', [TeacherController::class, 'submitRequest'])->name('requests.store');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/modules', [StudentController::class, 'modules'])->name('modules.index');
    Route::get('/modules/{id}/classroom', [StudentController::class, 'classroom'])->name('classroom.show');
    Route::post('/announcements/{id}/comments', [StudentController::class, 'storeAnnouncementComment'])->name('announcements.comments.store');
    Route::get('/grades', [StudentController::class, 'grades'])->name('grades');
    Route::get('/grades/index', [StudentController::class, 'grades'])->name('grades.index');
    Route::get('/schedule', [StudentController::class, 'schedule'])->name('schedule');
    Route::get('/absences', [StudentController::class, 'absences'])->name('absences');
    Route::post('/absences/justification', [StudentController::class, 'submitJustification'])->name('absences.justification');
    Route::post('/absences/justify', [StudentController::class, 'submitJustification'])->name('absences.justify');
    Route::get('/requests', [StudentController::class, 'requests'])->name('requests');
    Route::post('/requests', [StudentController::class, 'submitRequest'])->name('requests.submit');
    Route::post('/requests', [StudentController::class, 'submitRequest'])->name('requests.store');
});

require __DIR__.'/auth.php';
