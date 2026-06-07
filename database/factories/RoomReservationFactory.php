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
        $reservationDate = fake()->dateTimeBetween('+1 week', '+2 weeks');
        $startTime = fake()->time();
        $endTime = fake()->time('H:i', '+2 hours');
        
        // Parse time strings into hours and minutes
        list($startHour, $startMinute) = explode(':', $startTime);
        list($endHour, $endMinute) = explode(':', $endTime);
        
        // Clone the date object to avoid modifying the original
        $startDateTime = (clone $reservationDate)->setTime((int)$startHour, (int)$startMinute);
        $endDateTime = (clone $reservationDate)->setTime((int)$endHour, (int)$endMinute);
        
        return [
            'classroom_id' => \App\Models\Classroom::inRandomOrder()->first()?->id ?? \App\Models\Classroom::factory(),
            'user_id' => \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory(),
            'purpose' => fake()->sentence(),
            'description' => fake()->optional()->paragraph(),
            'reservation_date' => $reservationDate->format('Y-m-d'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'start_datetime' => $startDateTime,
            'end_datetime' => $endDateTime,
            'status' => fake()->randomElement(['pending', 'approved', 'rejected', 'cancelled']),
            'approved_by' => fake()->boolean(50) ? \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory() : null,
            'approved_at' => fake()->optional()->dateTime(),
            'rejection_reason' => fake()->optional()->sentence(),
        ];
    }
}
