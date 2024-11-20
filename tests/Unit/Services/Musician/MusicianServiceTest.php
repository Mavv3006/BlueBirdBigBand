<?php

namespace Tests\Unit\Services\Musician;

use App\Models\Instrument;
use App\Models\Musician;
use App\Services\Musician\MusicianService;
use Database\Seeders\InstrumentSeeder;
use Tests\TestCase;

class MusicianServiceTest extends TestCase
{
    private readonly MusicianService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MusicianService;
    }

    public function test_amount_of_active_musicians()
    {
        $instrument = Instrument::factory()->create([
            'name' => 'test',
            'order' => 2,
        ]);
        Musician::factory()
            ->count(3)
            ->for($instrument)
            ->create();

        $result = $this->service->activeMusicians();

        $this->assertCount(1, $result);
        $this->assertCount(3, $result[0]['musicians']);
    }

    public function test_format_of_active_musicians()
    {
        $instrument = Instrument::factory()->create([
            'name' => 'test',
            'order' => 2,
        ]);
        Musician::factory()
            ->count(3)
            ->for($instrument)
            ->create([
                'seating_position' => 12,
                'picture_filepath' => 'test',
            ]);

        $result = $this->service->activeMusicians();

        $this->verifyArrayStructure($result[0]);
    }

    public function test_active_musicians_with_seeder()
    {
        $this->seed(InstrumentSeeder::class);
        $instrument = Instrument::first();
        Musician::factory()
            ->count(3)
            ->for($instrument)
            ->create();

        $result = $this->service->activeMusicians();

        $this->assertCount(7, $result);
        $this->assertCount(3, $result[0]['musicians']);
        $this->verifyArrayStructure($result[0]);
    }

    public function test_active_musicians_dont_show_inactive_musicians()
    {
        $instrument = Instrument::factory()->create([
            'name' => 'test',
            'order' => 2,
        ]);
        Musician::factory()
            ->count(3)
            ->for($instrument)
            ->state(['isActive' => false])
            ->create();

        $result = $this->service->activeMusicians();

        $this->assertCount(1, $result);
        $this->assertCount(0, $result[0]['musicians']);
    }

    public function test_all_order_by()
    {
        $firstInstrument = Instrument::factory()->create(['name' => 'test1']);
        $secondInstrument = Instrument::factory()->create(['name' => 'test2']);
        $thirdInstrument = Instrument::factory()->create(['name' => 'test3']);

        Musician::factory()
            ->for($secondInstrument)
            ->create();
        Musician::factory()
            ->for($thirdInstrument)
            ->create();
        Musician::factory()
            ->for($firstInstrument)
            ->create();

        $all = $this->service->all()->toArray();

        $first = $all[0];
        $second = $all[1];
        $third = $all[2];

        $this->assertTrue($first['instrument_id'] < $second['instrument_id']);
        $this->assertTrue($second['instrument_id'] < $third['instrument_id']);
        $this->assertTrue($first['id'] > $second['id']);
        $this->assertTrue($third['id'] > $second['id']);
        $this->assertTrue($first['id'] > $third['id']);
    }

    public function test_ordering_instruments()
    {
        $firstInstrument = Instrument::factory()->create(['name' => 'test1', 'order' => 2]);
        $secondInstrument = Instrument::factory()->create(['name' => 'test2', 'order' => 1]);
        $thirdInstrument = Instrument::factory()->create(['name' => 'test3', 'order' => 3]);

        Musician::factory()
            ->for($secondInstrument)
            ->create();
        Musician::factory()
            ->for($thirdInstrument)
            ->create();
        Musician::factory()
            ->for($firstInstrument)
            ->create();

        $all = $this->service->activeMusicians();

        $first = $all[0];
        $second = $all[1];
        $third = $all[2];
        $this->assertTrue($first['instrument']['order'] < $second['instrument']['order']);
        $this->assertTrue($second['instrument']['order'] < $third['instrument']['order']);
        $this->assertTrue($first['instrument']['id'] > $second['instrument']['id']);
        $this->assertTrue($third['instrument']['id'] > $second['instrument']['id']);
        $this->assertTrue($third['instrument']['id'] > $first['instrument']['id']);
    }

    private function verifyArrayStructure($result): void
    {
        $instrumentFromResult = $result['instrument'];
        $this->assertNotNull($instrumentFromResult['id']);
        $this->assertNotNull($instrumentFromResult['name']);
        $this->assertNotNull($instrumentFromResult['default_picture_filepath']);
        $this->assertNotNull($instrumentFromResult['tux_filepath']);
        $this->assertNotNull($instrumentFromResult['order']);

        $musicianFromResult = $result['musicians'][0];
        $this->assertNotNull($musicianFromResult['id']);
        $this->assertNotNull($musicianFromResult['instrument_id']);
        $this->assertNotNull($musicianFromResult['firstname']);
        $this->assertNotNull($musicianFromResult['lastname']);
        $this->assertNotNull($musicianFromResult['seating_position']);
    }
}
