<?php

namespace Tests\Unit\StateMachines\NewsletterRequest;

use App\Enums\StateMachines\NewsletterState;
use App\Models\NewsletterRequest;
use Exception;
use Tests\TestCase;

class RequestedNewsletterStateTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_confirm()
    {
        $request = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Requested,
        ]);

        $request->state()->confirm();
        $this->assertEquals(NewsletterState::Confirmed, $request->status);

        $this->assertNotNull($request->confirmed_at);
        $this->assertNull($request->completed_at);
    }

    /**
     * @throws Exception
     */
    public function test_complete()
    {
        $request = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Requested,
        ]);

        $this->expectException(Exception::class);
        $request->state()->complete();

        $this->assertNull($request->completed_at);
        $this->assertNull($request->confirmed_at);
    }
}
