<?php

namespace Database\Factories;

use App\Models\SetlistEntry;
use App\Models\SetlistHeader;
use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SetlistEntryFactory extends Factory
{
    protected $model = SetlistEntry::class;

    public function definition(): array
    {
        return [
            'setlist_id' => SetlistHeader::all()->random(1)->first,
            'song_id' => Song::all()->random(1)->first,
            'sequence_number' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
