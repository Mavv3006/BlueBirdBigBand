<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\FeatureFlagName;
use App\Enums\NewsletterType;
use App\Enums\StateMachines\FeatureFlagState;
use App\Enums\StateMachines\NewsletterState;
use App\Mail\NewsletterConfirmationMail;
use App\Models\FeatureFlag;
use App\Models\NewsletterRequest;
use App\StateMachines\NewsletterRequest\RequestedNewsletterState;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NewsletterRequestControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        FeatureFlag::factory()->create([
            'name' => FeatureFlagName::Newsletter,
            'status' => FeatureFlagState::On,
        ]);
    }

    public function test_adding_request()
    {
        $this->assertDatabaseCount(NewsletterRequest::class, 0);

        $email = 'test@example.com';
        $response = $this->post(route('newsletter.request'), [
            'email' => $email,
            'type' => NewsletterType::Adding->value,
        ]);

        $response->assertRedirectToRoute('newsletter');
        $this->assertDatabaseCount(NewsletterRequest::class, 1);

        Mail::assertSent(NewsletterConfirmationMail::class);
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

    public function test_removing_request()
    {
        $this->assertDatabaseCount(NewsletterRequest::class, 0);

        $email = 'test@example.com';
        $response = $this->post(route('newsletter.request'), [
            'email' => $email,
            'type' => NewsletterType::Removing->value,
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
