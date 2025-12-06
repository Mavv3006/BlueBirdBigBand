<?php

namespace Tests\Inertia\Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DataPrivacyTest extends TestCase
{
    public function test_route_returns_successful()
    {
        $this->get('/datenschutz')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('/datenschutz')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Contact/DataPrivacyPage')
            );
    }
}
