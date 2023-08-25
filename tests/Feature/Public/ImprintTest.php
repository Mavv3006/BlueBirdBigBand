<?php

namespace Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ImprintTest extends TestCase
{
    public function testRouteReturnsSuccessful()
    {
        $this->get('/impressum')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('/impressum')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Contact/ImprintPage')
            );
    }
}
