<?php

namespace Database\Factories;

use App\Models\Instrument;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Instrument>
 */
class InstrumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'default_picture_filepath' => 'assets/musician_pictures/default/tux.png',
        ];
    }
}
