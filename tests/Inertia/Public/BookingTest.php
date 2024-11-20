<?php

namespace Tests\Inertia\Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class BookingTest extends TestCase
{
    public function test_route_returns_successful()
    {
        $this->get('/buchung')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('/buchung')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('LatestInfos/BookingPage')
            );
    }
}
