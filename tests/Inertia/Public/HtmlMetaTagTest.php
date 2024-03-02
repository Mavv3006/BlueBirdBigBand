<?php

namespace Tests\Inertia\Public;

use Tests\TestCase;

class HtmlMetaTagTest extends TestCase
{
    public function testMetaTags()
    {
        $html = $this->get('/about-us')->getContent();

        $this->assertStringContainsString('<meta property="og:type" content="website">', $html);
        $this->assertStringContainsString('<meta property="og:title" content="this is a test">', $html);
        $this->assertStringContainsString('<meta property="og:url" content="'.config('app.url').'">', $html);
        $this->assertStringContainsString('<meta property="og:description" content="bla bla bla">', $html);

        $this->assertStringContainsString('<meta property="twitter:title" content="this is a test">', $html);
        $this->assertStringContainsString('<meta property="twitter:card" content="summary_large_image">', $html);
        $this->assertStringContainsString('<meta property="twitter:url" content="'.config('app.url').'">', $html);
        $this->assertStringContainsString('<meta property="twitter:description" content="bla bla bla">', $html);
    }

    public function testHavingMeta1()
    {
        $html = $this->get('/anfahrt')->getContent();
        $this->assertStringContainsString('<meta property="og:type"', $html);
    }

    public function testHavingMeta2()
    {
        $html = $this->get('/about-us')->getContent();
        $this->assertStringContainsString('<meta property="og:type"', $html);
    }
}
