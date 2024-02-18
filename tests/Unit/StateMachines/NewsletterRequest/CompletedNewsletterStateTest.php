<?php

namespace Tests\Unit\StateMachines\NewsletterRequest;

use App\Enums\StateMachines\NewsletterState;
use App\Models\NewsletterRequest;
use App\StateMachines\NewsletterRequest\CompletedNewsletterState;
use Exception;
use Tests\TestCase;

class CompletedNewsletterStateTest extends TestCase
{
    public function testConfirm()
    {
        $request = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Completed,
        ]);

        $this->expectException(Exception::class);
        $state = $request->state();
        $this->assertInstanceOf(CompletedNewsletterState::class, $state);
        $state->confirm();

        $this->assertNull($request->completed_at);
        $this->assertNull($request->confirmed_at);
    }

    public function testComplete()
    {
        $request = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Completed,
        ]);

        $this->expectException(Exception::class);
        $request->state()->complete();

        $this->assertNull($request->completed_at);
        $this->assertNull($request->confirmed_at);
    }
}
