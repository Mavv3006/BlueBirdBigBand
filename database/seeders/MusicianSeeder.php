<?php

namespace Database\Seeders;

use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Database\Seeder;

class MusicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Musician::factory()->create([
            'instrument_id' => Instrument::where('name', 'Bandleader')->first(),
        ]);

        Musician::factory()
            ->count(2)
            ->create([
                'instrument_id' => Instrument::where('name', 'Gesang')->first(),
            ]);

        Musician::factory()
            ->count(8)
            ->create([
                'instrument_id' => Instrument::where('name', 'Saxophone')->first(),
            ]);

        Musician::factory()
            ->count(5)
            ->create([
                'instrument_id' => Instrument::where('name', 'Posaunen')->first(),
            ]);

        Musician::factory()
            ->count(6)
            ->create([
                'instrument_id' => Instrument::where('name', 'Trompeten')->first(),
            ]);

        Musician::factory()
            ->count(3)
            ->create([
                'instrument_id' => Instrument::where('name', 'Gitarre & Bass')->first(),
            ]);

        Musician::factory()
            ->count(3)
            ->create([
                'instrument_id' => Instrument::where('name', 'Drums')->first(),
            ]);
    }
}
