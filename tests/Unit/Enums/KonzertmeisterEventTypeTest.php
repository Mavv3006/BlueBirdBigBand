<?php

namespace Tests\Unit\Enums;

use App\Enums\KonzertmeisterEventType;
use Tests\TestCase;
use UnhandledMatchError;

class KonzertmeisterEventTypeTest extends TestCase
{
    public function test_from_ical_with_valid_input()
    {
        $type = KonzertmeisterEventType::fromIcal('Probe');

        $this->assertInstanceOf(KonzertmeisterEventType::class, $type);
        $this->assertEquals(KonzertmeisterEventType::Probe, $type);
    }

    public function test_from_ical_with_no_valid_input()
    {
        $this->assertThrows(
            fn () => KonzertmeisterEventType::fromIcal('bla bla'),
            UnhandledMatchError::class
        );
    }
}
