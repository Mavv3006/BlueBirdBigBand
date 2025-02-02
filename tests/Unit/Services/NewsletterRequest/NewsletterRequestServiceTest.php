<?php

namespace Tests\Unit\Services\NewsletterRequest;

use App\DataTransferObjects\NewsletterRequestDto;
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

        $dto = new NewsletterRequestDto(
            email: 'test@test.test',
            type: NewsletterType::Adding,
            data_privacy_consent: true,
            data_privacy_consent_text: 'asödlkjflkasdjf',
            ip_address: 'askdjfhalsf',
            status: NewsletterState::Requested,
        );
        NewsletterRequestService::createNew($dto);

        $this->assertDatabaseCount(NewsletterRequest::class, 1);
        $newsletterAddingRequest = NewsletterRequest::first();

        $this->assertEquals(NewsletterState::Requested, $newsletterAddingRequest->status);
    }

    public function test_create_removing_request()
    {
        Mail::fake();
        $dto = new NewsletterRequestDto(
            email: 'test@test.test',
            type: NewsletterType::Removing,
            data_privacy_consent: null,
            data_privacy_consent_text: null,
            ip_address: 'askdjfhalsf',
            status: NewsletterState::Requested,
        );
        NewsletterRequestService::createNew($dto);

        $this->assertDatabaseCount(NewsletterRequest::class, 1);
        $newsletterAddingRequest = NewsletterRequest::first();

        $this->assertEquals(NewsletterState::Confirmed, $newsletterAddingRequest->status);
    }
}
