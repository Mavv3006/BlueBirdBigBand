<?php

namespace App\DataTransferObjects\Concerts;

use App\Models\Band;
use Carbon\Carbon;

class ConcertDto
{
    public function __construct(
        public readonly Carbon                $date,
        public readonly Band                  $band,
        public readonly string                $start_time,
        public readonly string                $end_time,
        public readonly ConcertVenueDto       $venueDto,
        public readonly ConcertDescriptionDto $descriptionDto,
    )
    {
    }
}
