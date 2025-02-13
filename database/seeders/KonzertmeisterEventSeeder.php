<?php

namespace Database\Seeders;

use App\Models\KonzertmeisterEvent;
use Illuminate\Database\Seeder;
use Throwable;

class KonzertmeisterEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            KonzertmeisterEvent::factory()
                ->count(200)
                ->create();
        } catch (Throwable) {
            //
        }
    }
}
