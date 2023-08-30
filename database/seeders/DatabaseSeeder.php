<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
            ->call(DefaultAuthorizationSeeder::class)
            ->call(SongSeeder::class)
            ->call(SetlistSeeder::class);

        User::factory()
            ->create(['name' => 'admin', 'activated' => true])
            ->assignRole('admin');
        User::factory()
            ->create(['name' => 'musician', 'activated' => true])
            ->assignRole('musician');
    }
}
