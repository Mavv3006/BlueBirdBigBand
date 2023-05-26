<?php

namespace Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class AboutUsTest extends TestCase
{
    public function test_route_returns_successful()
    {
        $this->get('/about-us')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('/about-us')
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Band/AboutPage')
            );
    }
}
