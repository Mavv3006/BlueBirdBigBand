<?php

namespace Database\Seeders;

use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Database\Seeder;

class MusicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Musician::factory()
            ->count(Instrument::all()->count() * 4)
            ->create();
    }
}
