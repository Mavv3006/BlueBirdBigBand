<?php

namespace Database\Seeders;

use App\Models\Instrument;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instrumentNames = [
            ['name' => 'Bandleader', 'path' => 'assets/musician_pictures/default/tux-dirigent.png'],
            ['name' => 'Gesang', 'path' => null],
            ['name' => 'Saxophone', 'path' => 'assets/musician_pictures/default/tux-sax.jpg'],
            ['name' => 'Posaunen', 'path' => null],
            ['name' => 'Trompeten', 'path' => 'assets/musician_pictures/default/tux-trompeter.png'],
            ['name' => 'Rhythmusgruppe', 'path' => null],
        ];

        foreach ($instrumentNames as $instrumentName) {
            $this->createInstrument($instrumentName['name'], $instrumentName['path']);
        }
    }

    private function createInstrument(string $name, ?string $path)
    {
        Instrument::factory()->create([
            'name' => $name,
            'default_picture_filepath' => $path ?? 'assets/musician_pictures/default/tux.png',
        ]);
    }
}
