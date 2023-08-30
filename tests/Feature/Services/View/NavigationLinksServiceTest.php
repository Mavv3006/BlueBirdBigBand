<?php

namespace Services\View;

use App\DataTransferObjects\View\NavigationLinkDto;
use App\Enums\NavigationLinkType;
use App\Services\View\NavigationLinksService;
use PHPUnit\Framework\TestCase;

class NavigationLinksServiceTest extends TestCase
{
    protected NavigationLinksService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new NavigationLinksService();
    }

    public function testGetAllLinks()
    {
        $link = $this->service->getAllLinks();

        $this->assertCount(5, $link);
        $this->assertInstanceOf(NavigationLinkDto::class, $link[0]);
    }

    public function testGetLinkNavElements()
    {
        $allLinks = $this->service->getLinkNavElements();

        foreach ($allLinks as $link) {
            $this->assertInstanceOf(NavigationLinkDto::class, $link);
            $this->assertEquals(NavigationLinkType::Link, $link->type);
        }
    }

    public function testGetCtaNavElements()
    {
        $allLinks = $this->service->getCtaNavElements();

        foreach ($allLinks as $link) {
            $this->assertInstanceOf(NavigationLinkDto::class, $link);
            $this->assertEquals(NavigationLinkType::CallToAction, $link->type);
        }
    }
}
