<?php

namespace App\DataTransferObjects\Concerts;

readonly class ConcertDescriptionDto
{
    public function __construct(
        public string $event,
        public string $venue,
    ) {}
}
