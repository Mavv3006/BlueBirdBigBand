<?php

namespace Database\Seeders;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\Models\NewsletterRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class NewsletterRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $completedSequence = fn (Sequence $sequence) => [
            'status' => NewsletterState::Completed,
            'created_at' => Carbon::today()
                ->subDays(rand(130, 200))
                ->subHours(rand(0, 23))
                ->subMinutes(rand(0, 59)),
            'confirmed_at' => Carbon::today()
                ->subDays(rand(60, 129))
                ->subHours(rand(0, 23))
                ->subMinutes(rand(0, 59)),
            'completed_at' => Carbon::today()
                ->subDays(rand(0, 59))
                ->subHours(rand(0, 23))
                ->subMinutes(rand(0, 59)),
        ];
        $confirmedSequence = fn (Sequence $sequence) => [
            'status' => NewsletterState::Confirmed,
            'created_at' => Carbon::today()
                ->subDays(rand(60, 180))
                ->subHours(rand(0, 23))
                ->subMinutes(rand(0, 59)),
            'confirmed_at' => Carbon::today()
                ->subDays(rand(0, 59))
                ->subHours(rand(0, 23))
                ->subMinutes(rand(0, 59)),
        ];
        NewsletterRequest::factory()
            ->count(50)
            ->state(new Sequence(
                fn (Sequence $sequence) => [
                    'status' => NewsletterState::Requested,
                    'created_at' => Carbon::today()
                        ->subDays(rand(0, 180))
                        ->subHours(rand(0, 23))
                        ->subMinutes(rand(0, 59)),
                ],
                $confirmedSequence,
                $completedSequence
            ))
            ->create(['type' => NewsletterType::Adding]);

        NewsletterRequest::factory()
            ->count(50)
            ->state(new Sequence(
                $confirmedSequence,
                $completedSequence
            ))
            ->create(['type' => NewsletterType::Removing]);
    }
}
