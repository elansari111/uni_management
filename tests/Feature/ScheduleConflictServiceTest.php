<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Group;
use App\Models\Module;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\User;
use App\Services\ScheduleConflictService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleConflictServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles
        Role::create(['name' => 'Admin', 'slug' => 'admin', 'description' => 'Admin role']);
        Role::create(['name' => 'Teacher', 'slug' => 'teacher', 'description' => 'Teacher role']);
        Role::create(['name' => 'Student', 'slug' => 'student', 'description' => 'Student role']);
    }

    /**
     * Test classroom availability conflict prevention.
     */
    public function test_classroom_conflict_is_detected(): void
    {
        $level = \App\Models\Level::create([
            'name' => 'Licence 1',
            'code' => 'L1',
            'order' => 1
        ]);

        $classroom = Classroom::create([
            'name' => 'Amphi A',
            'code' => 'AMPHI-A',
            'building' => 'Block A',
            'capacity' => 120,
            'status' => 'available',
            'equipment' => ['projector', 'whiteboard']
        ]);

        $group = Group::create([
            'name' => 'G1_CS',
            'code' => 'G1-CS',
            'level_id' => $level->id,
        ]);

        $teacherRole = Role::where('slug', 'teacher')->first();
        $teacherUser = User::factory()->create([
            'name' => 'Prof. Smith',
            'email' => 'smith@univ.ma',
            'role_id' => $teacherRole->id,
        ]);

        $teacher = Teacher::factory()->create([
            'user_id' => $teacherUser->id,
            'specialization' => 'Computer Science',
        ]);

        $module1 = Module::create([
            'name' => 'Algebra 1',
            'code' => 'MATH101',
            'teacher_id' => $teacherUser->id,
            'group_id' => $group->id
        ]);

        // Existing schedule on Monday from 08:30 to 10:30
        Schedule::create([
            'module_id' => $module1->id,
            'classroom_id' => $classroom->id,
            'day_of_week' => 'monday',
            'start_time' => '08:30',
            'end_time' => '10:30',
            'type' => 'lecture'
        ]);

        $conflictService = new ScheduleConflictService();

        // 1. Overlapping classroom booking: Monday 09:00 - 11:00 (starts inside)
        $conflicts = $conflictService->checkConflicts([
            'classroom_id' => $classroom->id,
            'module_id' => $module1->id,
            'day_of_week' => 'monday',
            'start_time' => '09:00',
            'end_time' => '11:00',
        ]);

        $this->assertNotEmpty($conflicts);
        $this->assertEquals('classroom', $conflicts[0]['type']);

        // 2. Non-overlapping classroom booking: Monday 10:30 - 12:30
        $noConflicts = $conflictService->checkConflicts([
            'classroom_id' => $classroom->id,
            'module_id' => $module1->id,
            'day_of_week' => 'monday',
            'start_time' => '10:30',
            'end_time' => '12:30',
        ]);

        $this->assertEmpty($noConflicts);
    }

    /**
     * Test teacher availability conflict prevention.
     */
    public function test_teacher_conflict_is_detected(): void
    {
        $level = \App\Models\Level::create([
            'name' => 'Licence 1',
            'code' => 'L1',
            'order' => 1
        ]);

        $classroom1 = Classroom::create([
            'name' => 'Amphi A',
            'code' => 'AMPHI-A',
            'building' => 'Block A',
            'capacity' => 120,
            'status' => 'available',
        ]);

        $classroom2 = Classroom::create([
            'name' => 'Lab 2',
            'code' => 'LAB-2',
            'building' => 'Block B',
            'capacity' => 30,
            'status' => 'available',
        ]);

        $group1 = Group::create([
            'name' => 'G1_CS',
            'code' => 'G1-CS',
            'level_id' => $level->id,
        ]);

        $group2 = Group::create([
            'name' => 'G2_CS',
            'code' => 'G2-CS',
            'level_id' => $level->id,
        ]);

        $teacherRole = Role::where('slug', 'teacher')->first();
        $teacherUser = User::factory()->create([
            'name' => 'Prof. Smith',
            'email' => 'smith@univ.ma',
            'role_id' => $teacherRole->id,
        ]);

        $teacher = Teacher::factory()->create([
            'user_id' => $teacherUser->id,
            'specialization' => 'Computer Science',
        ]);

        $module1 = Module::create([
            'name' => 'Algebra 1',
            'code' => 'MATH101',
            'teacher_id' => $teacherUser->id,
            'group_id' => $group1->id
        ]);

        $module2 = Module::create([
            'name' => 'Physics 1',
            'code' => 'PHYS101',
            'teacher_id' => $teacherUser->id,
            'group_id' => $group2->id
        ]);

        // Teacher is teaching module1 in classroom1 on Monday from 14:00 to 16:00
        Schedule::create([
            'module_id' => $module1->id,
            'classroom_id' => $classroom1->id,
            'day_of_week' => 'monday',
            'start_time' => '14:00',
            'end_time' => '16:00',
            'type' => 'lecture'
        ]);

        $conflictService = new ScheduleConflictService();

        // Monday 15:00 - 17:00: Teacher overlap in classroom2 with module2
        $conflicts = $conflictService->checkConflicts([
            'classroom_id' => $classroom2->id,
            'module_id' => $module2->id,
            'day_of_week' => 'monday',
            'start_time' => '15:00',
            'end_time' => '17:00',
        ]);

        $this->assertNotEmpty($conflicts);
        $this->assertEquals('teacher', $conflicts[0]['type']);
    }

    /**
     * Test student group availability conflict prevention.
     */
    public function test_group_conflict_is_detected(): void
    {
        $level = \App\Models\Level::create([
            'name' => 'Licence 1',
            'code' => 'L1',
            'order' => 1
        ]);

        $classroom1 = Classroom::create([
            'name' => 'Amphi A',
            'code' => 'AMPHI-A',
            'building' => 'Block A',
            'capacity' => 120,
            'status' => 'available',
        ]);

        $classroom2 = Classroom::create([
            'name' => 'Lab 2',
            'code' => 'LAB-2',
            'building' => 'Block B',
            'capacity' => 30,
            'status' => 'available',
        ]);

        $group = Group::create([
            'name' => 'G1_CS',
            'code' => 'G1-CS',
            'level_id' => $level->id,
        ]);

        $teacherRole = Role::where('slug', 'teacher')->first();
        $teacherUser1 = User::factory()->create([
            'name' => 'Prof. Smith',
            'email' => 'smith@univ.ma',
            'role_id' => $teacherRole->id,
        ]);

        $teacherUser2 = User::factory()->create([
            'name' => 'Prof. Jones',
            'email' => 'jones@univ.ma',
            'role_id' => $teacherRole->id,
        ]);

        $teacher1 = Teacher::factory()->create([
            'user_id' => $teacherUser1->id,
            'specialization' => 'Computer Science',
        ]);

        $teacher2 = Teacher::factory()->create([
            'user_id' => $teacherUser2->id,
            'specialization' => 'Mathematics',
        ]);

        $module1 = Module::create([
            'name' => 'Algebra 1',
            'code' => 'MATH101',
            'teacher_id' => $teacherUser1->id,
            'group_id' => $group->id
        ]);

        $module2 = Module::create([
            'name' => 'Physics 1',
            'code' => 'PHYS101',
            'teacher_id' => $teacherUser2->id,
            'group_id' => $group->id
        ]);

        // Group is already having a class on Wednesday from 10:00 to 12:00
        Schedule::create([
            'module_id' => $module1->id,
            'classroom_id' => $classroom1->id,
            'day_of_week' => 'wednesday',
            'start_time' => '10:00',
            'end_time' => '12:00',
            'type' => 'lecture'
        ]);

        $conflictService = new ScheduleConflictService();

        // Overlapping group booking on Wednesday 11:00 - 13:00
        $conflicts = $conflictService->checkConflicts([
            'classroom_id' => $classroom2->id,
            'module_id' => $module2->id,
            'day_of_week' => 'wednesday',
            'start_time' => '11:00',
            'end_time' => '13:00',
        ]);

        $this->assertNotEmpty($conflicts);
        $this->assertEquals('group', $conflicts[0]['type']);
    }
}
