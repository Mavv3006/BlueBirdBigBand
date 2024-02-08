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
        $type = Random::generate(length: 1, charlist: '0-1') == '1'
            ? NewsletterType::Adding
            : NewsletterType::Removing;
        $status = Random::generate(length: 1, charlist: '0-1') == '1'
            ? NewsletterState::Requested
            : NewsletterState::Completed;

        return [
            'email' => $this->faker->email(),
            'type' => $type,
            'status' => $status,
        ];
    }
}
