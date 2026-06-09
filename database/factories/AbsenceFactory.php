<?php

namespace Database\Factories;

use App\Models\Absence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Absence>
 */
class AbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['present', 'absent', 'late', 'excused']);
        $status = $type === 'excused' ? 'justified' : fake()->randomElement(['pending', 'justified', 'unjustified']);

        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()?->id ?? \App\Models\Student::factory(),
            'module_id' => \App\Models\Module::inRandomOrder()->first()?->id ?? \App\Models\Module::factory(),
            'schedule_id' => \App\Models\Schedule::inRandomOrder()->first()?->id ?? \App\Models\Schedule::factory(),
            'date' => fake()->date(),
            'type' => $type,
            'status' => $status,
            'justification_id' => $status === 'justified' ? null : null,
            'notes' => fake()->optional()->randomElement(['Arrivé 10 min en retard', 'Rien à signaler']),
        ];
    }
}
