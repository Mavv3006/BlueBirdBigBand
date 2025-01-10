<?php

namespace Database\Seeders;

use App\Enums\StateMachines\UserStates;
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
            ->call(SetlistEntrySeeder::class)
            ->call(NewsletterRequestSeeder::class)
            ->call(KonzertmeisterEventSeeder::class);

        User::factory()
            ->create(['name' => 'admin', 'status' => UserStates::Activated])
            ->assignRole('admin');
        User::factory()
            ->create(['name' => 'musician', 'status' => UserStates::Activated])
            ->assignRole('musician');
    }
}
