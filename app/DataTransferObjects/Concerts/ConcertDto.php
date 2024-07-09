<?php

namespace App\DataTransferObjects\Concerts;

use App\Models\Band;
use Carbon\Carbon;

class ConcertDto
{
    public function __construct(
        public readonly Carbon $date,
        public readonly Band $band,
        public readonly string $start_time,
        public readonly string $end_time,
        public readonly ConcertVenueDto $venueDto,
        public readonly ConcertDescriptionDto $descriptionDto,
    ) {}

    public function toArray(): array
    {
        return [
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'event_description' => $this->descriptionDto->event,
            'venue_description' => $this->descriptionDto->venue,
            'venue_street' => $this->venueDto->street,
            'venue_street_number' => $this->venueDto->house_number,
            'band_id' => $this->band->id,
            'venue_plz' => $this->venueDto->venue->plz,
        ];
    }
}
