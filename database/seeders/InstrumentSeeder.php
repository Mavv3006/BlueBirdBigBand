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
            [
                'name' => 'Bandleader',
                'tux' => 'assets/musician_pictures/default/tux-dirigent.png',
                'default' => null,
            ],
            [
                'name' => 'Gesang',
                'tux' => null,
                'default' => 'assets/instruments/Vocals.jpg',
            ],
            [
                'name' => 'Saxophone',
                'tux' => 'assets/musician_pictures/default/tux-sax.jpg',
                'default' => 'assets/instruments/Sax.jpg',
            ],
            [
                'name' => 'Posaunen',
                'tux' => null,
                'default' => 'assets/instruments/Trombone.jpg',
            ],
            [
                'name' => 'Trompeten',
                'tux' => 'assets/musician_pictures/default/tux-trompeter.png',
                'default' => 'assets/instruments/Trumpet.jpg',
            ],
            [
                'name' => 'Gitarre & Bass',
                'tux' => null,
                'default' => 'assets/instruments/Guitar.jpg',
            ],
            [
                'name' => 'Drums',
                'tux' => null,
                'default' => 'assets/instruments/Drums.jpg',
            ],
        ];

        foreach ($instrumentNames as $instrumentName) {
            $this->createInstrument($instrumentName['name'], $instrumentName['tux'], $instrumentName['default']);
        }
    }

    private function createInstrument(string $name, ?string $path, ?string $default): void
    {
        Instrument::factory()->create([
            'name' => $name,
            'default_picture_filepath' => $default ?? 'assets/musician_pictures/default/tux.png',
            'tux_filepath' => $tux ?? 'assets/musician_pictures/default/tux.png',
        ]);
    }
}
