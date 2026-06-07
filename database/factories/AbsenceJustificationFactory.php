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
        $safeDate = fake()->dateTimeBetween('-5 years', 'now')->setTime(fake()->numberBetween(10, 16), 0, 0);
        $reviewedDate = $isReviewed ? fake()->dateTimeBetween($safeDate, 'now')->setTime(fake()->numberBetween(10, 16), 0, 0) : null;
        
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()?->id ?? \App\Models\Student::factory(),
            'reason' => fake()->paragraph(),
            'document_path' => fake()->optional()->filePath(),
            'status' => $status,
            'reviewed_by' => $isReviewed ? \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory() : null,
            'reviewed_at' => $reviewedDate,
            'review_notes' => $isReviewed ? fake()->optional()->sentence() : null,
        ];
    }
}
