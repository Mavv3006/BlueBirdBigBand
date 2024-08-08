<?php

namespace Services\KonzertmeisterIntegration;

use App\Services\KonzertmeisterIntegration\KonzertmeisterIntegrationService;
use Tests\TestCase;

class KonzertmeisterIntegrationTest extends TestCase
{
    public function test_pullData()
    {
        $this->assertCount(22, (new KonzertmeisterIntegrationService())->calendar->events());

    }
}
