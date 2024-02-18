<?php

namespace Tests\Unit\Services\NewsletterRequest;

use App\Models\NewsletterRequest;
use App\Services\NewsletterRequest\NewsletterRequestService;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class NewsletterRequestServiceTest extends TestCase
{
    public function testConfirmationLink()
    {
        $newsletterRequest = NewsletterRequest::factory()->create();

        $url = NewsletterRequestService::confirmationLink($newsletterRequest);

        $this->assertEquals("/newsletter/confirm/$newsletterRequest->id", parse_url($url)['path']);
    }
}
