<?php

namespace Tests\Unit;

use App\Services\KonzertmeisterIntegration\CalendarEventMapping;
use Carbon\Carbon;
use Tests\TestCase;

class CalendarEventMappingTest extends TestCase
{
    public function test_description_null()
    {
        $mapping = new CalendarEventMapping(
            'sdflkj',
            'sdlöfkj',
            'sdölfkj',
            Carbon::now(),
            Carbon::now(),
            null
        );

        $this->assertNull($mapping->description);
    }

    public function test_description_non_null()
    {
        $mapping = new CalendarEventMapping(
            'sdflkj',
            'sdlöfkj',
            'sdölfkj',
            Carbon::now(),
            Carbon::now(),
            'sdlfhwsf'
        );

        $this->assertNotNull($mapping->description);
        $this->assertEquals('sdlfhwsf', $mapping->description);
    }
}
