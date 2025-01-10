<?php

namespace Database\Factories;

use App\Enums\BandName;
use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Models\Band;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KonzertmeisterEvent>
 */
class KonzertmeisterEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_time = Carbon::instance($this->faker->dateTimeBetween('now', '+4 months'));

        try {
            $band = Band::query()
                ->whereIn('name', array_map(fn ($bandName) => $bandName->value, BandName::cases()))
                ->inRandomOrder()
                ->firstOrFail();
        } catch (ModelNotFoundException) {
            $band = Band::factory()->create([
                'name' => $this->faker->randomElement(BandName::cases()),
            ]);
        }

        return [
            'id' => $this->faker->randomNumber(7),
            'summary' => ($this->faker->sentence(3)),
            'location' => $this->faker->address,
            'dtstart' => $start_time,
            'dtend' => Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addHours(2),
            'description' => $this->faker->paragraph(1),
            'band_id' => $band->id,
            'type' => $this->faker->randomElement(KonzertmeisterEventType::cases()),
            'conversion_state' => $this->faker->randomElement(KonzertmeisterEventConversionState::cases()),
        ];
    }
}
