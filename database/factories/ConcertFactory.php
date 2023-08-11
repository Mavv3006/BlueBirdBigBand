<?php

namespace Database\Factories;

use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Carbon\Carbon;
use Exception;
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
        $start_time = Carbon::createFromTimestamp(
            $this
                ->faker
                ->dateTimeBetween(
                    '-3 years',
                    '+3 years'
                )->getTimestamp()
        );
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)
            ->addHours(2);
        $date = $this
            ->faker
            ->dateTimeThisYear('+12 months');

        return [
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'venue_street' => $this->faker->streetName,
            'venue_street_number' => $this->faker->buildingNumber,
            'venue_description' => $this->faker->text(25),
            'event_description' => $this->faker->text(25),
            'band_id' => Band::all()->random(1)->first(),
            'venue_plz' => Venue::all()->random(1)->first()
        ];
    }
}
