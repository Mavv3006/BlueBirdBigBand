<?php

namespace Tests\Inertia\Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class AboutUsTest extends TestCase
{
    public function testRouteReturnsSuccessful()
    {
        $this->get('/about-us')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('/about-us')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Band/AboutPage')
            );
    }
}
