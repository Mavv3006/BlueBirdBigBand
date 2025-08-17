<?php

namespace App\DataTransferObjects\Concerts;

use App\Models\Venue;

readonly class ConcertVenueDto
{
    public function __construct(
        public string $street,
        public string $house_number,
        public Venue $venue,
    ) {}
}
