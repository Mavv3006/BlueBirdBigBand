<?php

namespace Database\Factories;

use App\Models\Venue;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Venue>
 */
class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        try {
            return [
                'plz' => random_int(10000, 99999),
                'name' => $this->faker->city,
            ];
        } catch (Exception) {
            return [
                'plz' => 12345,
                'name' => $this->faker->city,
            ];
        }
    }
}
