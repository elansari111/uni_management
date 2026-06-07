<?php

namespace Database\Factories;

use App\Models\LessonLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LessonLog>
 */
class LessonLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => \App\Models\Teacher::inRandomOrder()->first()?->id ?? \App\Models\Teacher::factory(),
            'module_id' => \App\Models\Module::inRandomOrder()->first()?->id ?? \App\Models\Module::factory(),
            'classroom_id' => \App\Models\Classroom::inRandomOrder()->first()?->id ?? \App\Models\Classroom::factory(),
            'date' => fake()->date(),
            'start_time' => fake()->time(),
            'end_time' => fake()->time('H:i', '+2 hours'),
            'title' => fake()->sentence(3),
            'summary' => fake()->paragraph(),
            'objective' => fake()->paragraph(),
            'nature' => fake()->randomElement(['Cours', 'TD', 'TP']),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
