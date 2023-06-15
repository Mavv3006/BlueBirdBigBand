<?php

namespace Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function test_route_returns_successful()
    {
        $this->get('/kontakt')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('/kontakt')
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Contact/ContactPage')
            );
    }
}
