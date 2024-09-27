<?php

namespace Database\Seeders;

use App\Enums\BandName;
use App\Models\Band;
use Illuminate\Database\Seeder;

class DefaultBandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Band::factory()->create([
            'name' => BandName::BlueBird,
        ]);
        Band::factory()->create([
            'name' => BandName::DomeTown,
        ]);
    }
}
