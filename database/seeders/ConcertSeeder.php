<?php

namespace Database\Seeders;

use App\Models\Concert;
use Illuminate\Database\Seeder;

class ConcertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $num = 50;
        $this->createConcerts('-', $num);
        $this->createConcerts('+', $num);
    }

    /**
     * Creates a specified number of concert entries in the database with dates calculated
     * based on the provided sign (either '+' for future dates or '-' for past dates).
     *
     * @param string $sign Indicates the direction of date calculation ('+' for future,
     *                     '-' for past).
     * @param int $num The number of concerts to create.
     */
    protected function createConcerts(string $sign, int $num): void
    {
        $currentDelta = 0;

        for ($i = 0; $i < $num; $i++) {
            $currentDelta += rand(10, 30);
            $referenceDate = $sign === '+'
                ? now()->addDays($currentDelta)
                : now()->subDays($currentDelta);
            $startAt = $referenceDate->setTime(rand(18, 21), 0, 0);
            Concert::factory()->create([
                'start_at' => $startAt,
                'end_at' => (clone $startAt)->addHours(rand(2, 4)),
            ]);
        }
    }
}
