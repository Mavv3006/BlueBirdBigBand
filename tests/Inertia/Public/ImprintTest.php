<?php

namespace Tests\Inertia\Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ImprintTest extends TestCase
{
    public function test_route_returns_successful()
    {
        $this->get('/impressum')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('/impressum')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Contact/ImprintPage')
            );
    }
}
