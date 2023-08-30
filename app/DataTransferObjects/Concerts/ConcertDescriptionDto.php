<?php

namespace App\DataTransferObjects\Concerts;

class ConcertDescriptionDto
{
    public function __construct(
        public readonly string $event,
        public readonly string $venue,
    ) {
    }
}
