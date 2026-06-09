<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::inRandomOrder()->first();
        if (!$user) {
            $user = \App\Models\User::factory()->create([
                'role_id' => \App\Models\Role::inRandomOrder()->first()?->id,
            ]);
        }
        $titles = ['Annulation de cours', 'Nouvel horaire', 'Échéance pour les devoirs', 'Conférence', 'Stage'];
        $contents = [
            "Le cours de mardi est annulé.",
            "Nouvel horaire pour le module BDD.",
            "Les devoirs doivent être rendus d'ici vendredi.",
            "Conférence sur l'IA le 15 juin.",
            "Stage disponible pour les étudiants L3.",
        ];
        $key = array_rand($titles);

        return [
            'title' => $titles[$key],
            'content' => $contents[$key],
            'module_id' => \App\Models\Module::inRandomOrder()->first()?->id ?? \App\Models\Module::factory(),
            'target_role' => fake()->randomElement(['all', 'admin', 'teacher', 'student']),
            'created_by' => $user->id,
            'published_at' => fake()->dateTime(),
            'expires_at' => fake()->optional()->dateTimeBetween('+1 week', '+1 month'),
            'is_pinned' => fake()->boolean(20),
            'status' => 'published',
        ];
    }
}
