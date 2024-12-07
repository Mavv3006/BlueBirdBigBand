<?php

namespace Tests\Enums;

use App\Enums\KonzertmeisterEventType;
use Tests\TestCase;
use UnhandledMatchError;

class KonzertmeisterEventTypeTest extends TestCase
{
    public function testFromIcalWithValidInput()
    {
        $type = KonzertmeisterEventType::fromIcal('Probe');

        $this->assertInstanceOf(KonzertmeisterEventType::class, $type);
        $this->assertEquals(KonzertmeisterEventType::Probe, $type);
    }

    public function testFromIcalWithNoValidInput()
    {
        $this->assertThrows(
            fn () => KonzertmeisterEventType::fromIcal('bla bla'),
            UnhandledMatchError::class
        );
    }
}
