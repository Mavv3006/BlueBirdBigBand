<?php

namespace App\DataTransferObjects\Concerts;

use Carbon\Carbon;

readonly class FormattedConcertDto
{
    public function __construct(
        public int $id,
        public Carbon $start_at,
        public Carbon $end_at,
        public string $band,
        public ConcertDescriptionDto $description,
        public ConcertAddressDto $address,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'start_at' => $this->start_at->toIso8601String(),
            'end_at' => $this->end_at->toIso8601String(),
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
