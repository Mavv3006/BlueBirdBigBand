<?php

namespace Tests\Inertia\Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PressInfoTest extends TestCase
{
    public function testRouteReturnsSuccessful()
    {
        $this->get('/presse')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('/presse')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('LatestInfos/PressInfoPage')
            );
    }
}
