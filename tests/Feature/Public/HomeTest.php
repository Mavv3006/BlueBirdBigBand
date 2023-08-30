<?php

namespace Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testRouteReturnsSuccessful()
    {
        $this->get('/')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('/')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Concert')
            );
    }
}
