<?php

namespace Database\Factories;

use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_path' => 'fever.mp3',
            'title' => 'Fever',
            'genre' => 'Swing',
            'arranger' => 'Roger Holmes',
            'author' => 'J. Davenport, E. Cooley',
            'size' => $this->faker->randomNumber(2),
        ];
    }
}
