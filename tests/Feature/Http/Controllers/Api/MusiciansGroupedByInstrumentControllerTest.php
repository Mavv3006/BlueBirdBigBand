<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MusiciansGroupedByInstrumentControllerTest extends TestCase
{
    public function test_single_instrument_single_musician()
    {
        $instrument = Instrument::factory()->create();
        Musician::factory()->for($instrument)->create();
        $this->assertDatabaseCount(Musician::class, 1);
        $this->assertDatabaseCount(Instrument::class, 1);

        $response = $this->get(route('api.musicians.grouped-by-instrument'));

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has(1)
            ->first(fn (AssertableJson $json) => $json
                ->has('name')
                ->has('image_path')
                ->has('musicians', 1)
                ->has('musicians.0', fn (AssertableJson $json) => $json
                    ->has('name')
                )
            )
        );
    }

    public function test_multiple_everything()
    {
        $firstInstrument = Instrument::factory()->create();
        $secondInstrument = Instrument::factory()->create();
        Musician::factory()
            ->count(10)
            ->state(new Sequence(
                ['instrument_id' => $firstInstrument->id],
                ['instrument_id' => $secondInstrument->id]
            ))
            ->create();

        $response = $this->get(route('api.musicians.grouped-by-instrument'));

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has(2)
            ->first(fn (AssertableJson $json) => $json
                ->has('name')
                ->has('image_path')
                ->has('musicians', 5)
                ->has('musicians.0', fn (AssertableJson $json) => $json
                    ->has('name')
                )
            )
        );
    }

    public function test_only_include_active_musicians()
    {
        $instrument = Instrument::factory()->create();
        Musician::factory()->for($instrument)->create(['isActive' => true]);
        Musician::factory()->for($instrument)->create(['isActive' => false]);

        $response = $this->get(route('api.musicians.grouped-by-instrument'));

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has(1)
            ->first(fn (AssertableJson $json) => $json
                ->has('name')
                ->has('image_path')
                ->has('musicians', 1)
                ->has('musicians.0', fn (AssertableJson $json) => $json
                    ->has('name')
                )
            )
        );
    }

    public function test_sort_musicians_by_name()
    {
        $instrument = Instrument::factory()->create();
        Musician::factory()->for($instrument)->create(['firstname' => 'a', 'lastname' => 'b']);
        Musician::factory()->for($instrument)->create(['firstname' => 'c', 'lastname' => 'd']);
        Musician::factory()->for($instrument)->create(['firstname' => 'a', 'lastname' => 'a']);
        Musician::factory()->for($instrument)->create(['firstname' => 'b', 'lastname' => 'c']);

        $response = $this->get(route('api.musicians.grouped-by-instrument'));

        $response->assertOk();
        $musicians = $response->json('0.musicians');
        $this->assertequals([
            'a a',
            'a b',
            'b c',
            'c d',
        ], collect($musicians)->pluck('name')->toArray());
    }
}
