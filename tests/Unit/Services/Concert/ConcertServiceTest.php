<?php

namespace Services\Concert;

use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use App\Services\Concert\ConcertService;
use Tests\TestCase;

class ConcertServiceTest extends TestCase
{
    private ConcertService $concertService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->concertService = new ConcertService();
    }

    public function test_getRequestVenue_find_Venue()
    {
        Venue::create(['plz' => 12000, 'name' => 'test']);
        $data = [
            'venue' => [
                'create_new_venue' => false,
                'selected_plz' => 12000,
            ],
        ];

        $venue = $this->concertService->getRequestVenue($data);

        $this->assertEquals(12000, $venue->plz);
        $this->assertEquals('test', $venue->name);
    }

    public function test_getRequestVenue_create_Venue()
    {
        Venue::create(['plz' => 12000, 'name' => 'test']);
        $data = [
            'venue' => [
                'create_new_venue' => true,
                'new_plz' => 13000,
                'new_name' => 'bla bla',
            ],
        ];

        $venue = $this->concertService->getRequestVenue($data);

        $this->assertEquals(13000, $venue->plz);
        $this->assertEquals('bla bla', $venue->name);
    }

    public function test_getRequestVenue_find_create_Venue()
    {
        Venue::create(['plz' => 12000, 'name' => 'test']);
        $data = [
            'venue' => [
                'create_new_venue' => true,
                'new_plz' => 12000,
                'new_name' => 'bla bla',
            ],
        ];

        $venue = $this->concertService->getRequestVenue($data);

        $this->assertEquals(12000, $venue->plz);
        $this->assertEquals('test', $venue->name);
    }

    public function test_createDto()
    {
        Band::create(['name' => 'test']);
        $data = [
            'date' => '31.12.2020',
            'band_id' => 1,
            'times' => [
                'start' => '10:00:00',
                'end' => '12:00:00',
            ],
            'venue' => [
                'create_new_venue' => true,
                'new_plz' => 12000,
                'new_name' => 'test 2',
                'street' => 'street name',
                'house_number' => '12a',
            ],
            'description' => [
                'event' => 'event description',
                'venue' => 'venue description',
            ],
        ];

        $dto = $this->concertService->createDto($data);

        $this->assertEquals('2020-12-31', $dto->date->format('Y-m-d'));
        $this->assertEquals('test', $dto->band->name);
        $this->assertEquals('10:00:00', $dto->start_time);
        $this->assertEquals('12:00:00', $dto->end_time);
        $this->assertEquals('street name', $dto->venueDto->street);
        $this->assertEquals('12a', $dto->venueDto->house_number);
        $this->assertEquals(12000, $dto->venueDto->venue->plz);
        $this->assertEquals('test 2', $dto->venueDto->venue->name);
        $this->assertEquals('event description', $dto->descriptionDto->event);
        $this->assertEquals('venue description', $dto->descriptionDto->venue);
    }

    public function test_delete()
    {
        Venue::factory()->create();
        Band::factory()->create();
        $concert = Concert::factory()->create();

        $this->assertDatabaseCount(Concert::class, 1);

        $this->concertService->delete($concert);

        $this->assertDatabaseCount(Concert::class, 0);
    }
}
