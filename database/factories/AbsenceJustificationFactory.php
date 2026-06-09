<?php

namespace Database\Factories;

use App\Models\AbsenceJustification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AbsenceJustification>
 */
class AbsenceJustificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'approved', 'rejected']);
        $isReviewed = $status !== 'pending';
        $safeDate = fake()->dateTimeBetween('-2 months', 'now');
        $reviewedDate = $isReviewed ? fake()->dateTimeBetween($safeDate, 'now') : null;
        $reasons = ['Maladie', 'Rendez-vous médical', 'Urgence familiale', 'Panne de transport', 'Autre'];

        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()?->id ?? \App\Models\Student::factory(),
            'reason' => fake()->randomElement($reasons),
            'document_path' => fake()->optional()->filePath(),
            'status' => $status,
            'reviewed_by' => $isReviewed ? \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory() : null,
            'reviewed_at' => $reviewedDate,
            'review_notes' => $isReviewed ? fake()->optional()->randomElement(['Accepté', 'Refusé - Justificatif invalide', 'Accepté - Document valide']) : null,
        ];
    }
}
