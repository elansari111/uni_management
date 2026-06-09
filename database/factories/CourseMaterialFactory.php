<?php

namespace Database\Factories;

use App\Models\CourseMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseMaterial>
 */
class CourseMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::whereHas('role', function($q) {
            $q->where('slug', 'teacher');
        })->inRandomOrder()->first();
        if (!$user) {
            $user = \App\Models\User::factory()->create([
                'role_id' => \App\Models\Role::where('slug', 'teacher')->first()?->id,
            ]);
        }
        $titles = ['Cours 1', 'TD 1', 'TP 1', 'Exercices', 'Corrigés', 'Syllabus'];
        $fileTypes = ['pdf', 'docx', 'pptx'];

        return [
            'module_id' => \App\Models\Module::inRandomOrder()->first()?->id ?? \App\Models\Module::factory(),
            'title' => fake()->randomElement($titles),
            'description' => fake()->optional()->sentence(),
            'file_path' => fake()->filePath(),
            'file_type' => fake()->randomElement($fileTypes),
            'file_size' => fake()->numberBetween(100, 10000),
            'uploaded_by' => $user->id,
            'status' => 'published',
            'published_at' => fake()->optional()->dateTime(),
        ];
    }
}
