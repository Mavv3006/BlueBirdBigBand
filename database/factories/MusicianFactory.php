<?php

namespace Database\Factories;

use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Musician>
 */
class MusicianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'isActive' => true,
            'instrument_id' => Instrument::all()->random(1)->first(),
            'seating_position' => 0,
        ];
    }
}
