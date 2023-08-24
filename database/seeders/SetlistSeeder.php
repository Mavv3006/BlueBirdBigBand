<?php

namespace Database\Seeders;

use App\Models\Concert;
use App\Models\SetlistHeader;
use Illuminate\Database\Seeder;

class SetlistSeeder extends Seeder
{
    public function run(): void
    {
        $concerts = Concert::all();

        foreach ($concerts as $concert) {
            SetlistHeader::factory()
                ->for($concert)
                ->count(4)
                ->create();
        }
    }
}
