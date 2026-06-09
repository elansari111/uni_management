<?php

namespace Database\Factories;

use App\Models\RoomReservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoomReservation>
 */
class RoomReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reservationDate = fake()->dateTimeBetween('+1 week', '+2 months');
        $timeSlots = [
            ['start' => '08:00', 'end' => '10:00'],
            ['start' => '10:00', 'end' => '12:00'],
            ['start' => '14:00', 'end' => '16:00'],
            ['start' => '16:00', 'end' => '18:00'],
        ];
        $slot = fake()->randomElement($timeSlots);
        $purposes = ['Cours', 'TD', 'TP', 'Conférence', 'Réunion'];

        return [
            'classroom_id' => \App\Models\Classroom::inRandomOrder()->first()?->id ?? \App\Models\Classroom::factory(),
            'user_id' => \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory(),
            'purpose' => fake()->randomElement($purposes),
            'description' => fake()->optional()->sentence(),
            'reservation_date' => $reservationDate->format('Y-m-d'),
            'start_time' => $slot['start'],
            'end_time' => $slot['end'],
            'status' => fake()->randomElement(['pending', 'approved', 'rejected', 'cancelled']),
            'approved_by' => fake()->boolean(60) ? \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory() : null,
            'approved_at' => fake()->optional()->dateTime(),
            'rejection_reason' => fake()->optional()->randomElement(['Salle déjà réservée', 'Heure non disponible']),
        ];
    }
}
