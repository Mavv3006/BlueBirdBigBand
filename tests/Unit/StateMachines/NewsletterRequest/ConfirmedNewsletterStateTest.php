<?php

namespace Tests\Unit\StateMachines\NewsletterRequest;

use App\Enums\StateMachines\NewsletterState;
use App\Models\NewsletterRequest;
use App\StateMachines\NewsletterRequest\ConfirmedNewsletterState;
use Exception;
use Tests\TestCase;

class ConfirmedNewsletterStateTest extends TestCase
{
    public function testConfirm()
    {
        $request = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Confirmed,
        ]);

        $this->expectException(Exception::class);
        $request->state()->confirm();

        $this->assertNull($request->confirmed_at);
        $this->assertNull($request->completed_at);
    }

    /**
     * @throws Exception
     */
    public function testComplete()
    {
        $request = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Confirmed,
        ]);

        $state = $request->state();
        $this->assertInstanceOf(ConfirmedNewsletterState::class, $state);
        $state->complete();
        $this->assertEquals(NewsletterState::Completed, $request->status);

        $this->assertNotNull($request->completed_at);
        $this->assertNull($request->confirmed_at);
    }
}
