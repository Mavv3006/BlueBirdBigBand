<?php

namespace App\DataTransferObjects\View;

class FooterContactLinkDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $icon,
        public readonly string $link,
    ) {}
}
