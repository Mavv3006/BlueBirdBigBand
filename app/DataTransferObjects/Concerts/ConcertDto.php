<?php

namespace App\DataTransferObjects\Concerts;

use App\Models\Band;
use Carbon\Carbon;

readonly class ConcertDto
{
    public function __construct(
        public Carbon $date,
        public Band $band,
        public string $start_time,
        public string $end_time,
        public ConcertVenueDto $venueDto,
        public ConcertDescriptionDto $descriptionDto,
    ) {}

    /**
     * @return array{
     *     date: Carbon,
     *     start_time: string,
     *     end_time: string,
     *     event_description: string,
     *     venue_description: string,
     *     venue_street: string,
     *     venue_street_number: string,
     *     band_id: int,
     *     venue_plz: int
     * }
     */
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
