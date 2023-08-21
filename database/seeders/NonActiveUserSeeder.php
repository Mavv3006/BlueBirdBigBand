<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class NonActiveUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10)->create(['activated' => false]);
    }
}
