<?php

namespace Database\Seeders;

use App\Models\Concert;
use App\Models\SetlistEntry;
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
                ->has(SetlistEntry::factory()->count(4), 'entries')
                ->create();
        }
    }
}
