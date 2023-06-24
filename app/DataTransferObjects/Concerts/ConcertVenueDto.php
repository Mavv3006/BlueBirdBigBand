<?php

namespace App\DataTransferObjects\Concerts;

use App\Models\Venue;

class ConcertVenueDto
{
    public function __construct(
        public readonly string $street,
        public readonly string $house_number,
        public readonly Venue  $venue,
    )
    {
    }
}
