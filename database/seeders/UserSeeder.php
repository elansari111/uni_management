<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin user
        $adminUser = User::firstOrCreate([
            'email' => 'admin@upf.ma'
        ], [
            'name' => 'Dr. Amina Benali',
            'password' => Hash::make('password'),
            'phone' => '+212 6 00 00 00 00',
            'role_id' => 1,
            'email_verified_at' => now(),
        ]);

        // Create Teacher user
        $teacherUser = User::firstOrCreate([
            'email' => 'teacher@upf.ma'
        ], [
            'name' => 'Pr. Karim El Amrani',
            'password' => Hash::make('password'),
            'phone' => '+212 6 11 11 11 11',
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);

        // Create Student user
        $studentUser = User::firstOrCreate([
            'email' => 'student@upf.ma'
        ], [
            'name' => 'Youssef El Mansouri',
            'password' => Hash::make('password'),
            'phone' => '+212 6 22 22 22 22',
            'role_id' => 3,
            'email_verified_at' => now(),
        ]);

        // Create Teacher profile
        if ($teacherUser->teacher()->doesntExist()) {
            $nameParts = explode(' ', $teacherUser->name);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';
            $teacherUser->teacher()->create([
                'employee_number' => 'EMP-001',
                'first_name' => $firstName,
                'last_name' => $lastName,
                'specialization' => 'Développement Web',
                'hire_date' => now()->subYears(5)->toDateString(),
            ]);
        }

        // Create Student profile
        if ($studentUser->student()->doesntExist()) {
            $nameParts = explode(' ', $studentUser->name);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';
            $studentUser->student()->create([
                'student_number' => '20210101',
                'first_name' => $firstName,
                'last_name' => $lastName,
                'enrollment_date' => now(),
                'group_id' => 1,
            ]);
        }

        // Create 5 more teachers
        $teachers = [
            ['name' => 'Pr. Leila Saidi', 'email' => 'leila.saidi@upf.ma', 'specialization' => 'Intelligence Artificielle', 'employee_number' => 'EMP-002'],
            ['name' => 'Dr. Omar Benjelloun', 'email' => 'omar.benjelloun@upf.ma', 'specialization' => 'Bases de Données', 'employee_number' => 'EMP-003'],
            ['name' => 'Pr. Sarah El Khattabi', 'email' => 'sarah.elkhattabi@upf.ma', 'specialization' => 'Réseaux Informatiques', 'employee_number' => 'EMP-004'],
            ['name' => 'Dr. Hassan Amrani', 'email' => 'hassan.amrani@upf.ma', 'specialization' => 'Génie Logiciel', 'employee_number' => 'EMP-005'],
            ['name' => 'Pr. Fatima Zohra El Idrissi', 'email' => 'fatima.zohra@upf.ma', 'specialization' => 'Algorithmique', 'employee_number' => 'EMP-006'],
        ];

        foreach ($teachers as $teacherData) {
            $teacher = User::firstOrCreate([
                'email' => $teacherData['email']
            ], [
                'name' => $teacherData['name'],
                'password' => Hash::make('password'),
                'phone' => fake()->unique()->phoneNumber(),
                'role_id' => 2,
                'email_verified_at' => now(),
            ]);

            if ($teacher->teacher()->doesntExist()) {
                $nameParts = explode(' ', $teacher->name);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
                $teacher->teacher()->create([
                    'employee_number' => $teacherData['employee_number'],
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'specialization' => $teacherData['specialization'],
                    'hire_date' => fake()->dateTimeBetween('-10 years', '-1 year'),
                ]);
            }
        }

        // Create 10 more students
        $students = [
            ['name' => 'Ahmed El Fassi', 'student_id' => '20210102', 'email' => 'ahmed.elfassi@upf.ma', 'group_id' => 1],
            ['name' => 'Sanaa Benali', 'student_id' => '20210103', 'email' => 'sanaa.benali@upf.ma', 'group_id' => 1],
            ['name' => 'Younes El Idrissi', 'student_id' => '20210104', 'email' => 'younes.elidrissi@upf.ma', 'group_id' => 1],
            ['name' => 'Fatima El Amrani', 'student_id' => '20210105', 'email' => 'fatima.elamrani@upf.ma', 'group_id' => 1],
            ['name' => 'Oussama Saidi', 'student_id' => '20210106', 'email' => 'oussama.saidi@upf.ma', 'group_id' => 2],
            ['name' => 'Hanae El Mansouri', 'student_id' => '20210107', 'email' => 'hanae.elmansouri@upf.ma', 'group_id' => 2],
            ['name' => 'Anas Benjelloun', 'student_id' => '20210108', 'email' => 'anas.benjelloun@upf.ma', 'group_id' => 2],
            ['name' => 'Soukaina El Khattabi', 'student_id' => '20210109', 'email' => 'soukaina.elkhattabi@upf.ma', 'group_id' => 2],
            ['name' => 'Mehdi Amrani', 'student_id' => '20210110', 'email' => 'mehdi.amrani@upf.ma', 'group_id' => 3],
            ['name' => 'Zineb Saidi', 'student_id' => '20210111', 'email' => 'zineb.saidi@upf.ma', 'group_id' => 3],
        ];

        foreach ($students as $studentData) {
            $student = User::firstOrCreate([
                'email' => $studentData['email']
            ], [
                'name' => $studentData['name'],
                'password' => Hash::make('password'),
                'phone' => fake()->unique()->phoneNumber(),
                'role_id' => 3,
                'email_verified_at' => now(),
            ]);

            if ($student->student()->doesntExist()) {
                $nameParts = explode(' ', $student->name);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
                $student->student()->create([
                    'student_number' => $studentData['student_id'],
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'enrollment_date' => now(),
                    'group_id' => $studentData['group_id'],
                ]);
            }
        }
    }
}
