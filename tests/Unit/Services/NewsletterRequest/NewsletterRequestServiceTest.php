<?php

namespace Tests\Unit\Services\NewsletterRequest;

use App\Models\NewsletterRequest;
use App\Services\NewsletterRequest\NewsletterRequestService;
use Tests\TestCase;

class NewsletterRequestServiceTest extends TestCase
{
    public function testConfirmationLink()
    {
        $newsletterRequest = NewsletterRequest::factory()->create();

        $url = NewsletterRequestService::confirmationLink($newsletterRequest);

        $this->assertEquals("http://localhost:8000/newsletter/confirm/$newsletterRequest->id", $url);
    }
}
