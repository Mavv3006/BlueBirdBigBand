<?php

namespace Tests\Feature;

use App\Enums\FeatureFlagName;
use App\Enums\NewsletterType;
use App\Enums\StateMachines\FeatureFlagState;
use App\Enums\StateMachines\NewsletterState;
use App\Mail\NewsletterAdminNotificationMail;
use App\Mail\NewsletterConfirmationMail;
use App\Models\FeatureFlag;
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
        Mail::fake();
        FeatureFlag::factory()->create([
            'name' => FeatureFlagName::Newsletter,
            'status' => FeatureFlagState::On,
        ]);
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
        $email = 'test@example.com';

        // 1) User goes to /newsletter
        $this->get(route('newsletter'))
            ->assertOk();

        // 2) User enters e-mail into text field and clicks button
        $this->post(route('newsletter.request'), data: [
            'email' => $email,
            'type' => NewsletterType::Adding->value,
        ]);

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

    public function test_unsubscribe_from_newsletter()
    {
        /*
         * Scenario:
         * 1) User goes to /newsletter
         * 2) User enters e-mail into text field and clicks button
         * 3) Admin receives notification email
         * 4) Admin completes request
         * */

        // 0) Setup
        $email = 'test@example.com';

        // 1) User goes to /newsletter
        $this->get(route('newsletter'))
            ->assertOk();

        // 2) User enters e-mail into text field and clicks button
        $this->post(route('newsletter.request'), data: [
            'email' => $email,
            'type' => NewsletterType::Removing->value,
        ]);

        $this->assertDatabaseCount(NewsletterRequest::class, 1);
        $newsletterAddingRequest = NewsletterRequest::first();
        $this->assertEquals($email, $newsletterAddingRequest->email);
        $this->assertEquals(NewsletterType::Removing, $newsletterAddingRequest->type);
        $this->assertEquals(NewsletterState::Confirmed, $newsletterAddingRequest->status);

        // 3) Admin receives notification email
        Mail::assertSent(NewsletterAdminNotificationMail::class);

        // 4) Admin completes request
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

    public function test_subscribe_from_qr_code_page()
    {
        /*
         * Scenario:
         * 1) User goes to /newsletter/subscribe
         * 2) User enters e-mail into text field and clicks button
         * 3) User receives an e-mail with confirmation and clicks link in confirmation e-mail
         * 4) Admin completes newsletter request
         * */

        // 0) Setup
        $email = 'test@example.com';

        // 1) User goes to /newsletter
        $this->get(route('newsletter.subscribe'))
            ->assertOk();

        // 2) User enters e-mail into text field and clicks button
        $this->post(route('newsletter.request'), data: [
            'email' => $email,
            'type' => NewsletterType::Adding->value,
        ]);

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
