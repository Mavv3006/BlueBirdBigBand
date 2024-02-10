<?php

namespace Tests\Inertia\Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ArrivalTest extends TestCase
{
    public function testRouteReturnsSuccessful()
    {
        $this->get('/anfahrt')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('/anfahrt')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Band/ArrivalPage')
            );
    }
}
