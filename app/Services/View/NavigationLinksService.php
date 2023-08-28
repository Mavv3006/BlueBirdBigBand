<?php

namespace App\Services\View;

use App\DataTransferObjects\View\NavigationLinkDto;
use App\Enums\NavigationLinkType;

class NavigationLinksService
{
    /**
     * @var NavigationLinkDto[]
     */
    private array $links;

    public function __construct()
    {
        $this->links = [
            new NavigationLinkDto(
                name: 'Home',
                link: '/v2',
                type: NavigationLinkType::Link
            ),
            new NavigationLinkDto(
                name: 'Auftritte',
                link: '/v2/auftritte',
                type: NavigationLinkType::Link
            ),
            new NavigationLinkDto(
                name: 'Band',
                link: '/v2/band',
                type: NavigationLinkType::Link
            ),
            new NavigationLinkDto(
                name: 'Kontakt',
                link: '/v2/kontakt',
                type: NavigationLinkType::Link
            ),
            new NavigationLinkDto(
                name: 'Login',
                link: '/v2/login',
                type: NavigationLinkType::CallToAction
            ),
        ];
    }

    /**
     * @return NavigationLinkDto[]
     */
    public function getAllLinks(): array
    {
        return $this->links;
    }

    /**
     * @return NavigationLinkDto[]
     */
    public function getLinkNavElements(): array
    {
        return array_filter(
            array: $this->links,
            callback: fn (NavigationLinkDto $val) => $val->type === NavigationLinkType::Link
        );
    }

    /**
     * @return NavigationLinkDto[]
     */
    public function getCtaNavElements(): array
    {
        return array_filter(
            array: $this->links,
            callback: fn (NavigationLinkDto $val) => $val->type === NavigationLinkType::CallToAction
        );
    }
}
