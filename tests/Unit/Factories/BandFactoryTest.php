<?php

namespace Tests\Unit\Factories;

use App\Models\Band;
use PHPUnit\Framework\TestCase;

class BandFactoryTest extends TestCase
{
    public function test_validate_name()
    {
        $band = Band::factory()->make();

        $this->assertNotnull($band->name);
    }
}
