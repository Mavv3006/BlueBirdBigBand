<?php

namespace Public;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function testRouteReturnsSuccessful()
    {
        $this->get('/kontakt')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('/kontakt')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Contact/ContactPage')
            );
    }
}
