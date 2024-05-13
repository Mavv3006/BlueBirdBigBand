<?php

namespace App\DataTransferObjects;

readonly class SeoMetaDto
{
    public function __construct(
        public string $title,
        public string $description,
    ) {
    }
}
