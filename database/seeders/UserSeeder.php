<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = \App\Models\Role::where('slug', 'admin')->first();
        $teacherRole = \App\Models\Role::where('slug', 'teacher')->first();
        $studentRole = \App\Models\Role::where('slug', 'student')->first();

        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => bcrypt('password'),
                'role_id' => $adminRole->id,
                'phone' => '+1234567890',
            ],
            [
                'name' => 'Teacher User',
                'email' => 'teacher@test.com',
                'password' => bcrypt('password'),
                'role_id' => $teacherRole->id,
                'phone' => '+1234567891',
            ],
            [
                'name' => 'Student User',
                'email' => 'student@test.com',
                'password' => bcrypt('password'),
                'role_id' => $studentRole->id,
                'phone' => '+1234567892',
            ],
        ];

        foreach ($users as $user) {
            $createdUser = \App\Models\User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );

            $role = \App\Models\Role::find($createdUser->role_id);
            $nameParts = explode(' ', $createdUser->name, 2);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            if ($role->slug === 'student') {
                if (!$createdUser->student) {
                    $group = \App\Models\Group::inRandomOrder()->first();
                    $createdUser->student()->create([
                        'group_id' => $group ? $group->id : null,
                        'student_number' => 'STU-' . strtoupper(\Illuminate\Support\Str::random(6)),
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'enrollment_date' => now(),
                    ]);
                }
            } elseif ($role->slug === 'teacher') {
                if (!$createdUser->teacher) {
                    $createdUser->teacher()->create([
                        'employee_number' => 'T-' . strtoupper(\Illuminate\Support\Str::random(6)),
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'specialization' => 'General',
                        'hire_date' => now(),
                    ]);
                }
            }
        }

        // Create 5 additional teachers
        for ($i = 0; $i < 5; $i++) {
            $user = \App\Models\User::factory()->teacher()->create();
            $nameParts = explode(' ', $user->name, 2);
            $user->teacher()->create([
                'employee_number' => 'T-' . strtoupper(\Illuminate\Support\Str::random(6)),
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? '',
                'specialization' => fake()->randomElement(['Computer Science', 'Mathematics', 'Physics', 'Chemistry', 'Biology']),
                'hire_date' => fake()->date(),
            ]);
        }

        // Create 10 additional students
        for ($i = 0; $i < 10; $i++) {
            $user = \App\Models\User::factory()->student()->create();
            $nameParts = explode(' ', $user->name, 2);
            $group = \App\Models\Group::inRandomOrder()->first();
            $user->student()->create([
                'group_id' => $group ? $group->id : null,
                'student_number' => 'STU-' . strtoupper(\Illuminate\Support\Str::random(6)),
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? '',
                'enrollment_date' => fake()->date(),
            ]);
        }
    }
}
