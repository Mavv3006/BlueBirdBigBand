<?php

namespace Tests\Unit\Services\NewsletterRequest;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\Models\NewsletterRequest;
use App\Services\NewsletterRequest\NewsletterRequestService;
use Mail;
use Tests\TestCase;

class NewsletterRequestServiceTest extends TestCase
{
    public function test_confirmation_link()
    {
        $newsletterRequest = NewsletterRequest::factory()->create();

        $url = NewsletterRequestService::confirmationLink($newsletterRequest);

        $this->assertEquals("/newsletter/confirm/$newsletterRequest->id", parse_url($url)['path']);
    }

    public function test_create_adding_request()
    {
        Mail::fake();
        $email = 'test@test.test';
        $type = NewsletterType::Adding;

        NewsletterRequestService::createNew($email, $type);

        $this->assertDatabaseCount(NewsletterRequest::class, 1);
        $newsletterAddingRequest = NewsletterRequest::first();

        $this->assertEquals(NewsletterState::Requested, $newsletterAddingRequest->status);
    }

    public function test_create_removing_request()
    {
        Mail::fake();
        $email = 'test@test.test';
        $type = NewsletterType::Removing;

        NewsletterRequestService::createNew($email, $type);

        $this->assertDatabaseCount(NewsletterRequest::class, 1);
        $newsletterAddingRequest = NewsletterRequest::first();

        $this->assertEquals(NewsletterState::Confirmed, $newsletterAddingRequest->status);
    }
}
