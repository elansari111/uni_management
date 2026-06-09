<?php

namespace Database\Factories;

use App\Models\GeneratedDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GeneratedDocument>
 */
class GeneratedDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $safeDate = fake()->dateTimeBetween('-2 months', 'now');
        $types = ['transcript', 'certificate', 'attestation', 'grade_report', 'other', 'work_attestation', 'mission_order'];
        $titles = ['Certificat scolarité 2024', 'Attestation inscription', 'Relevé notes S1', 'Relevé notes S2'];

        return [
            'request_id' => fake()->boolean(50) ? \App\Models\AdministrativeRequest::inRandomOrder()->first()?->id ?? \App\Models\AdministrativeRequest::factory() : null,
            'student_id' => \App\Models\Student::inRandomOrder()->first()?->id ?? \App\Models\Student::factory(),
            'type' => fake()->randomElement($types),
            'title' => fake()->randomElement($titles),
            'file_path' => fake()->filePath(),
            'file_type' => fake()->randomElement(['pdf', 'docx']),
            'generated_by' => \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory(),
            'generated_at' => $safeDate,
            'is_official' => fake()->boolean(),
            'reference_number' => fake()->optional()->bothify('UPF-####-####'),
        ];
    }
}
