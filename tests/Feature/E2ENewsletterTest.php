<?php

namespace Tests\Feature;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\Mail\NewsletterAdminNotificationMail;
use App\Mail\NewsletterConfirmationMail;
use App\Models\NewsletterRequest;
use App\Services\NewsletterRequest\NewsletterRequestService;
use Exception;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class E2ENewsletterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_register_for_newsletter()
    {
        /*
         * Scenario:
         * 1) User goes to /newsletter
         * 2) User enters e-mail into text field and clicks button
         * 3) User receives an e-mail with confirmation and clicks link in confirmation e-mail
         * 4) Admin completes newsletter request
         * */

        // 0) Setup
        Mail::fake();
        $email = 'test@example.com';

        // 1) User goes to /newsletter
        $this->get(route('newsletter'))
            ->assertOk();

        // 2) User enters e-mail into text field and clicks button
        $this->post(route('newsletter.request'), data: [
            'email' => $email,
            'type' => NewsletterType::Adding->value,
        ])->assertRedirectToRoute('newsletter');

        $this->assertDatabaseCount(NewsletterRequest::class, 1);
        $newsletterAddingRequest = NewsletterRequest::first();
        $this->assertEquals($email, $newsletterAddingRequest->email);
        $this->assertEquals(NewsletterType::Adding, $newsletterAddingRequest->type);
        $this->assertEquals(NewsletterState::Requested, $newsletterAddingRequest->status);

        Mail::assertSent(NewsletterConfirmationMail::class, $email);

        // 3) User receives an e-mail with confirmation and clicks link in confirmation e-mail
        $confirmationLink = NewsletterRequestService::confirmationLink($newsletterAddingRequest);
        $this->get($confirmationLink)
            ->assertRedirectToRoute('newsletter.confirm.success');
        $newsletterAddingRequest->refresh();
        $this->assertEquals(NewsletterState::Confirmed, $newsletterAddingRequest->status);
        Mail::assertSent(NewsletterAdminNotificationMail::class);

        // 4) Admin completes newsletter request
        $newsletterAddingRequest->refresh();
        try {
            $newsletterAddingRequest
                ->state()
                ->complete();
        } catch (Exception $e) {
            self::fail($e->getMessage());
        }
        $newsletterAddingRequest->refresh();

        $this->assertEquals(NewsletterState::Completed, $newsletterAddingRequest->status);
    }
}
