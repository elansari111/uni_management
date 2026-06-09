<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
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
        $comments = [
            'Très intéressant !',
            'Merci pour le cours.',
            'Pourrais-je avoir la réponse ?',
            'Super module !',
            'Peut mieux faire.',
            'C\'est clair.',
        ];

        return [
            'user_id' => $user->id,
            'content' => fake()->randomElement($comments),
            'commentable_type' => fake()->randomElement([\App\Models\Module::class, \App\Models\Announcement::class, \App\Models\CourseMaterial::class, \App\Models\AdministrativeRequest::class]),
            'commentable_id' => fake()->numberBetween(1, 10),
            'parent_id' => null,
            'status' => 'approved',
        ];
    }
}
