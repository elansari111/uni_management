<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cc1 = fake()->randomFloat(1, 8, 20);
        $cc2 = fake()->randomFloat(1, 7, 20);
        $exam = fake()->randomFloat(1, 6, 20);
        $finalGrade = (($cc1 + $cc2) / 2) * 0.4 + $exam * 0.6;
        
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()?->id ?? \App\Models\Student::factory(),
            'module_id' => \App\Models\Module::inRandomOrder()->first()?->id ?? \App\Models\Module::factory(),
            'cc1' => $cc1,
            'cc2' => $cc2,
            'exam' => $exam,
            'final_grade' => $finalGrade,
            'remarks' => fake()->optional()->randomElement(['Bon travail', 'Très bien', 'Peut mieux faire']),
        ];
    }
}
