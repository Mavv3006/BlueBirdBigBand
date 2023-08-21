<?php

namespace Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PressInfoTest extends TestCase
{
    public function test_route_returns_successful()
    {
        $this->get('/presse')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('/presse')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('LatestInfos/PressInfoPage')
            );
    }
}
