<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'table_id' => \App\Models\Table::factory(),
            'reservation_datetime' => $this->faker->dateTimeBetween('+1 day', '+30 days'),
            'party_size' => $this->faker->numberBetween(1, 8),
            'special_requests' => $this->faker->optional()->sentence(),
            'status' => 'confirmed',
        ];
    }
}
