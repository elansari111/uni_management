<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'code' => strtoupper(fake()->unique()->bothify('???###')),
            'description' => fake()->paragraph(),
            'credits' => fake()->numberBetween(1, 6),
            'teacher_id' => function() {
                $teacherUser = \App\Models\User::whereHas('role', function($q) {
                    $q->where('slug', 'teacher');
                })->inRandomOrder()->first();
                return $teacherUser ? $teacherUser->id : null;
            },
            'group_id' => \App\Models\Group::inRandomOrder()->first()?->id ?? \App\Models\Group::factory(),
            'level' => fake()->randomElement(['L1', 'L2', 'L3', 'M1', 'M2']),
            'semester' => fake()->randomElement(['S1', 'S2']),
            'status' => 'active',
        ];
    }
}
