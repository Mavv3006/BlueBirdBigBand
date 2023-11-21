<?php

namespace Services\Musician;

use App\Models\Instrument;
use App\Models\Musician;
use App\Services\Musician\MusicianService;
use Tests\TestCase;

class MusicianServiceTest extends TestCase
{
    private readonly MusicianService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MusicianService();
    }

    public function testActiveMusicians()
    {
        $instrument = Instrument::factory()->create(['name' => 'test']);
        Musician::factory()
            ->count(3)
            ->for($instrument)
            ->create();

        $result = $this->service->activeMusicians()->toArray();

        $this->assertCount(1, $result);
        $this->assertCount(3, $result[0]['musicians']);
        $this->assertInstanceOf(Instrument::class, $result[0]['instrument']);
        $this->assertInstanceOf(Musician::class, $result[0]['musicians'][0]);
    }

    public function testActiveMusiciansDontShowInactiveMusicians()
    {
        $instrument = Instrument::factory()->create(['name' => 'test']);
        Musician::factory()
            ->count(3)
            ->for($instrument)
            ->state(['isActive' => false])
            ->create();

        $result = $this->service->activeMusicians()->toArray();

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
        $this->assertTrue($first['id'] === 3);
        $this->assertTrue($second['id'] === 1);
        $this->assertTrue($third['id'] === 2);
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
        $this->assertTrue($first['instrument']['id'] === 2);
        $this->assertTrue($second['instrument']['id'] === 1);
        $this->assertTrue($third['instrument']['id'] === 3);
    }
}
