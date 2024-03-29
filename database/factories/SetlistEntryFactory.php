<?php

namespace Database\Factories;

use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SetlistEntryFactory extends Factory
{
    protected $model = SetlistEntry::class;

    public function definition(): array
    {
        return [
            'concert_id' => Concert::all()->random(1)->first()->id,
            'song_id' => Song::all()->random(1)->first()->id,
            'sequence_number' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
