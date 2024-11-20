<?php

namespace Tests\Inertia\Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_route_returns_successful()
    {
        $this->get('/')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('/')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Index')
            );
    }
}
