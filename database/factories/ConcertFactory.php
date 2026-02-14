<?php

namespace Database\Factories;

use App\Enums\ConcertStatus;
use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Concert>
 */
class ConcertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = now()->addDays(rand(1, 100))->setTime(20, 0);

        return [
            'start_at' => $start,
            'end_at' => (clone $start)->addHours(2),
            'venue_street' => $this->faker->streetName,
            'venue_street_number' => $this->faker->buildingNumber,
            'venue_description' => $this->faker->text(25),
            'event_description' => $this->faker->text(25),
            'band_id' => Band::all()->random(1)->first(),
            'venue_plz' => Venue::all()->random(1)->first(),
            'status' => $this->faker->randomElement(ConcertStatus::cases()),
        ];
    }
}
