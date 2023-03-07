<?php

namespace Database\Seeders;

use App\Models\Instrument;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $instrumentNames = [
            'Bandleader',
            'Gesang',
            'Saxophone',
            'Posaunen',
            'Trompeten',
            'Rhythmusgruppe'
        ];

        Instrument::factory()
            ->count(sizeof($instrumentNames))
            ->sequence(fn(Sequence $sequence) => ['name' => $instrumentNames[$sequence->index]])
            ->create();
    }
}
