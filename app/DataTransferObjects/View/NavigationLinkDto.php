<?php

namespace App\DataTransferObjects\View;

use App\Enums\NavigationLinkType;

class NavigationLinkDto
{
    public function __construct(
        public readonly string             $name,
        public readonly string             $link,
        public readonly NavigationLinkType $type,
    )
    {
    }
}
