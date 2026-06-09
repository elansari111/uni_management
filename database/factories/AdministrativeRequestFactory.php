<?php

namespace Database\Factories;

use App\Models\AdministrativeRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AdministrativeRequest>
 */
class AdministrativeRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'in_progress', 'approved', 'rejected', 'completed']);
        $isProcessed = in_array($status, ['in_progress', 'approved', 'rejected', 'completed']);
        $safeDate = fake()->dateTimeBetween('-2 months', 'now');
        $processedDate = $isProcessed ? fake()->dateTimeBetween($safeDate, 'now') : null;
        $types = ['transcript', 'certificate', 'attestation', 'other', 'work_attestation', 'mission_order'];
        $titles = ['Certificat de scolarité', 'Attestation d\'inscription', 'Relevé de notes', 'Demande administrative'];

        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()?->id ?? \App\Models\Student::factory(),
            'teacher_id' => null,
            'type' => fake()->randomElement($types),
            'title' => fake()->randomElement($titles),
            'description' => fake()->sentence(),
            'status' => $status,
            'submitted_at' => $safeDate,
            'processed_by' => $isProcessed ? \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory() : null,
            'processed_at' => $processedDate,
            'admin_notes' => $isProcessed ? fake()->optional()->sentence() : null,
        ];
    }
}
