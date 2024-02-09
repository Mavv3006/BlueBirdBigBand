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
    public function testConfirm()
    {
        $request = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Requested,
        ]);

        $request->state()->confirm();
        $this->assertEquals(NewsletterState::Confirmed, $request->status);
    }

    /**
     * @throws Exception
     */
    public function testComplete()
    {
        $request = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Requested,
        ]);

        $this->expectException(Exception::class);
        $request->state()->complete();
    }
}
