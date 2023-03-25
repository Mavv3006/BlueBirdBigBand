<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this
            ->call(UserSeeder::class)
            ->call(VenueSeeder::class)
            ->call(BandSeeder::class)
            ->call(ConcertSeeder::class)
            ->call(InstrumentSeeder::class)
            ->call(MusicianSeeder::class)
            ->call(DefaultAuthorizationSeeder::class);
    }
}
