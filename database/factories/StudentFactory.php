<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                $existingStudentUser = \App\Models\User::where('role_id', \App\Models\Role::where('slug', 'student')->first()?->id)
                    ->whereDoesntHave('student')
                    ->inRandomOrder()
                    ->first();
                
                if ($existingStudentUser) {
                    return $existingStudentUser->id;
                }
                
                return \App\Models\User::factory()->student()->create()->id;
            },
            'group_id' => function () {
                return \App\Models\Group::inRandomOrder()->first()?->id ?? \App\Models\Group::factory()->create()->id;
            },
            'student_number' => 'STU' . fake()->unique()->randomNumber(6),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'enrollment_date' => fake()->date(),
        ];
    }
}
