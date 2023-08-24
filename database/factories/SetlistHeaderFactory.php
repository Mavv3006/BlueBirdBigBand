<?php

namespace Database\Factories;

use App\Models\Concert;
use App\Models\SetlistHeader;
use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SetlistHeaderFactory extends Factory
{
    protected $model = SetlistHeader::class;

    public function definition(): array
    {
        return [
            'concert_id' => Concert::all()->random(1)->first(),
            'song_id' => Song::all()->random(1)->first(),
            'sequence_number' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
