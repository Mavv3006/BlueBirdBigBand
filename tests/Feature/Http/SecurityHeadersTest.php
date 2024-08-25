<?php

namespace Http;

use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function testSecurityHeadersOnLandingPage(): void
    {
        $response = $this->get('/');

        $this->checkHeaders($response);
    }

    public function testSecurityHeadersOnAboutUs(): void
    {
        $response = $this->get('/about-us');

        $this->checkHeaders($response);
    }

    public function testSecurityHeadersOnPressInfo(): void
    {
        $response = $this->get('/presse');

        $this->checkHeaders($response);
    }

    /**
     * @param TestResponse $response
     * @return void
     */
    public function checkHeaders(TestResponse $response): void
    {
        $response->assertStatus(200);
        $response->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        $response->assertHeader('Content-Security-Policy', "default-src 'self'");
        $response->assertHeader('X-Frame-Options', 'deny');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader(
            'Permissions-Policy',
            'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=(), interest-cohort=(), fullscreen=(self)'
        );
        $response->assertHeader('server', '');
    }
}
