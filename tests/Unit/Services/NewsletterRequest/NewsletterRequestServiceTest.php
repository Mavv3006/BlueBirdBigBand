<?php

namespace Tests\Unit\Services\NewsletterRequest;

use App\DataTransferObjects\NewsletterRequestDto;
use App\Enums\FeatureFlagName;
use App\Enums\NewsletterType;
use App\Enums\StateMachines\FeatureFlagState;
use App\Enums\StateMachines\NewsletterState;
use App\Models\FeatureFlag;
use App\Models\NewsletterRequest;
use App\Services\FeatureFlag\FeatureFlagService;
use App\Services\NewsletterRequest\NewsletterRequestService;
use Mail;
use Tests\TestCase;

class NewsletterRequestServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        FeatureFlag::factory()->create(['name' => FeatureFlagName::Newsletter, 'status' => FeatureFlagState::On]);
    }

    public function test_confirmation_link()
    {
        $newsletterRequest = NewsletterRequest::factory()->create();

        $url = NewsletterRequestService::confirmationLink($newsletterRequest);

        $this->assertEquals("/newsletter/confirm/$newsletterRequest->id", parse_url($url)['path']);
    }

    public function test_redirect_after_following_confirmation_link()
    {
        $newsletterRequest = NewsletterRequest::factory()->create(['status' => NewsletterState::Requested]);
        $url = NewsletterRequestService::confirmationLink($newsletterRequest);

        $response = $this->get($url);

        $response->assertRedirectToRoute('newsletter.confirm.success');
    }

    public function test_access_success_route()
    {
        $this->get(route('newsletter.confirm.success'))->assertSuccessful();
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
