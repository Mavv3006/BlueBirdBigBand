<?php

namespace Database\Seeders;

use App\Models\Song;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Song::factory()->create();
        Song::factory()->create([
            'title' => 'Frosty the Snow Man',
            'file_path' => 'frosty.mp3',
            'genre' => 'Swing',
            'arranger' => 'Jerry Nowak',
            'author' => 'S. Nelson, J. Rollins',
        ]);
    }
}
