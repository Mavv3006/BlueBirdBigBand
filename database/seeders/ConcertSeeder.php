<?php

namespace Database\Seeders;

use App\Models\Concert;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class ConcertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 0; $i < 25; $i++) {
            try {
                Concert::factory()->create();
            } catch (QueryException $e) {
                print_r("(" . $i . ") Failed to create " . Concert::class . "\nMessage: " . $e->getMessage() . "\n\n");
            }
        }
    }
}
