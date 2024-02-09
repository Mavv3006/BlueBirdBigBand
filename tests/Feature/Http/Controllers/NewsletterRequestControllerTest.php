<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\Models\NewsletterRequest;
use App\StateMachines\NewsletterRequest\RequestedNewsletterState;
use Tests\TestCase;

class NewsletterRequestControllerTest extends TestCase
{
    public function testAddingRequest()
    {
        $this->withoutExceptionHandling();
        $this->assertDatabaseCount(NewsletterRequest::class, 0);

        $email = 'test@example.com';
        $response = $this->post(route('newsletter.request'), [
            'email' => $email,
            'type' => NewsletterType::Adding->value
        ]);

        $response->assertRedirectToRoute('newsletter');
        $this->assertDatabaseCount(NewsletterRequest::class, 1);

        $request = NewsletterRequest::first();
        $this->assertInstanceOf(RequestedNewsletterState::class, $request->state());
        $this->assertNull($request->confirmed_at);
        $this->assertNull($request->completed_at);
        $this->assertNotNull($request->created_at);
        $this->assertNotNull($request->updated_at);
        $this->assertEquals($email, $request->email);
        $this->assertEquals(NewsletterType::Adding, $request->type);
        $this->assertEquals(NewsletterState::Requested, $request->status);
    }
    public function testRemovingRequest()
    {
        $this->withoutExceptionHandling();
        $this->assertDatabaseCount(NewsletterRequest::class, 0);

        $email = 'test@example.com';
        $response = $this->post(route('newsletter.request'), [
            'email' => $email,
            'type' => NewsletterType::Removing->value
        ]);

        $response->assertRedirectToRoute('newsletter');
        $this->assertDatabaseCount(NewsletterRequest::class, 1);

        $request = NewsletterRequest::first();
        $this->assertInstanceOf(RequestedNewsletterState::class, $request->state());
        $this->assertNull($request->confirmed_at);
        $this->assertNull($request->completed_at);
        $this->assertNotNull($request->created_at);
        $this->assertNotNull($request->updated_at);
        $this->assertEquals($email, $request->email);
        $this->assertEquals(NewsletterType::Removing, $request->type);
        $this->assertEquals(NewsletterState::Requested, $request->status);
    }
}
