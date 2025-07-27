<?php

namespace App\DataTransferObjects\Concerts;

use Carbon\Carbon;

readonly class FormattedConcertDto
{
    public function __construct(
        public int $id,
        public Carbon $date,
        public Carbon $start_time,
        public Carbon $end_time,
        public string $band,
        public ConcertDescriptionDto $description,
        public ConcertAddressDto $address,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->locale('de')->format('Y-m-d'),
            'start_time' => $this->start_time->format('H:i'),
            'end_time' => $this->end_time->format('H:i'),
            'band' => $this->band,
            'description' => [
                'venue' => $this->description->venue,
                'event' => $this->description->event,
            ],
            'address' => [
                'street' => $this->address->street,
                'number' => $this->address->number,
                'plz' => $this->address->plz,
                'city' => $this->address->city,
            ],
        ];
    }
}
