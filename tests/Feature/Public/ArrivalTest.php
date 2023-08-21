<?php

namespace Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ArrivalTest extends TestCase
{
    public function test_route_returns_successful()
    {
        $this->get('/anfahrt')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('/anfahrt')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Band/ArrivalPage')
            );
    }
}
