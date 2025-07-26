<?php

namespace App\DataTransferObjects\View;

use App\Enums\NavigationLinkType;

readonly class NavigationLinkDto
{
    public function __construct(
        public string $name,
        public string $link,
        public NavigationLinkType $type,
    ) {}
}
