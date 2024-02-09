<?php

namespace Database\Factories;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\Models\NewsletterRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

/**
 * @extends Factory<NewsletterRequest>
 */
class NewsletterRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = match (Random::generate(length: 1, charlist: '0-1')) {
            '0' => NewsletterType::Adding,
            '1' => NewsletterType::Removing
        };
        $status = match (Random::generate(length: 1, charlist: '0-2')) {
            '0' => NewsletterState::Requested,
            '1' => NewsletterState::Confirmed,
            '2' => NewsletterState::Completed
        };

        return [
            'email' => $this->faker->email,
            'type' => $type,
            'status' => $status,
        ];
    }
}
