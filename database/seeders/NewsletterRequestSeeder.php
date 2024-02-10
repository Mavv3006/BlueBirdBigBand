<?php

namespace Database\Seeders;

use App\Models\NewsletterRequest;
use Illuminate\Database\Seeder;

class NewsletterRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsletterRequest::factory()
            ->count(40)
            ->create();
    }
}
