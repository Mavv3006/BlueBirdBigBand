<?php

namespace Database\Seeders;

use App\Enums\BandNames;
use App\Models\Band;
use Illuminate\Database\Seeder;

class BandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Band::factory()->create([
            'name' => BandNames::BlueBird,
        ]);
        Band::factory()->create([
            'name' => BandNames::DomeTown,
        ]);

        Band::factory()->count(5)->create();
    }
}
