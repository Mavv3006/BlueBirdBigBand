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
        $instrumentData = [
            [
                'name' => 'Bandleader',
                'tux' => 'assets/musician_pictures/default/tux-dirigent.png',
                'default' => null,
                'order' => 1,
            ],
            [
                'name' => 'Gesang',
                'tux' => null,
                'default' => 'assets/instruments/Vocals.jpg',
                'order' => 2,
            ],
            [
                'name' => 'Saxophone',
                'tux' => 'assets/musician_pictures/default/tux-sax.jpg',
                'default' => 'assets/instruments/Sax.jpg',
                'order' => 3,
            ],
            [
                'name' => 'Posaunen',
                'tux' => null,
                'default' => 'assets/instruments/Trombone.jpg',
                'order' => 4,
            ],
            [
                'name' => 'Trompeten',
                'tux' => 'assets/musician_pictures/default/tux-trompeter.png',
                'default' => 'assets/instruments/Trumpet.jpg',
                'order' => 5,
            ],
            [
                'name' => 'Gitarre & Bass',
                'tux' => null,
                'default' => 'assets/instruments/Guitar.jpg',
                'order' => 6,
            ],
            [
                'name' => 'Drums',
                'tux' => null,
                'default' => 'assets/instruments/Drums.jpg',
                'order' => 7,
            ],
        ];

        foreach ($instrumentData as $singleInstrumentDataPoint) {
            $this->createInstrument(
                name: $singleInstrumentDataPoint['name'],
                path: $singleInstrumentDataPoint['tux'],
                default: $singleInstrumentDataPoint['default'],
                order: $singleInstrumentDataPoint['order']
            );
        }
    }

    private function createInstrument(string $name, ?string $path, ?string $default, ?int $order): void
    {
        Instrument::factory()->create([
            'name' => $name,
            'default_picture_filepath' => $default ?? 'assets/musician_pictures/default/tux.png',
            'tux_filepath' => $path ?? 'assets/musician_pictures/default/tux.png',
            'order' => $order,
        ]);
    }
}
