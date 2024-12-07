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

    public function testAmountOfActiveMusicians()
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

    public function testFormatOfActiveMusicians()
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

    public function testActiveMusiciansWithSeeder()
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

    public function testActiveMusiciansDontShowInactiveMusicians()
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

    public function testAllOrderBy()
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

    public function test_sorting_musicians_by_firstname()
    {
        $instrument = Instrument::factory()->create(['name' => 'test1', 'order' => 1]);

        Musician::factory()
            ->for($instrument)
            ->create(['firstname' => 'Test']);
        Musician::factory()
            ->for($instrument)
            ->create(['firstname' => 'Bla Bla']);

        $all = $this->service->activeMusicians();

        $this->assertEquals('Bla Bla', $all[0]['musicians'][0]['firstname']);
        $this->assertEquals('Test', $all[0]['musicians'][1]['firstname']);
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
