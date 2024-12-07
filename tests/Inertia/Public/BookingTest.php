<?php

namespace Tests\Inertia\Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class BookingTest extends TestCase
{
    public function testRouteReturnsSuccessful()
    {
        $this->get('/buchung')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('/buchung')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('LatestInfos/BookingPage')
            );
    }
}
