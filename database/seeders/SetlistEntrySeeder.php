<?php

namespace Database\Seeders;

use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\Song;
use Illuminate\Database\Seeder;

class SetlistEntrySeeder extends Seeder
{
    public function run(): void
    {
        $songs = Song::all();
        $concerts = Concert::all();

        foreach ($songs as $song) {
            foreach ($concerts as $concert) {
                SetlistEntry::factory()->create([
                    'song_id' => $song->id,
                    'concert_id' => $concert->id,
                ]);
            }
        }
    }
}
