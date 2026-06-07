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
        
        // Generate a safe date (avoid DST transitions)
        $safeDate = fake()->dateTimeBetween('-5 years', 'now')->setTime(fake()->numberBetween(10, 16), 0, 0);
        $processedDate = $isProcessed ? fake()->dateTimeBetween($safeDate, 'now')->setTime(fake()->numberBetween(10, 16), 0, 0) : null;
        
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()?->id ?? \App\Models\Student::factory(),
            'teacher_id' => null,
            'type' => fake()->randomElement(['transcript', 'certificate', 'attestation', 'other']),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => $status,
            'submitted_at' => $safeDate,
            'processed_by' => $isProcessed ? \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory() : null,
            'processed_at' => $processedDate,
            'admin_notes' => $isProcessed ? fake()->optional()->sentence() : null,
        ];
    }
}
