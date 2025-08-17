<?php

namespace App\DataTransferObjects\Concerts;

readonly class ConcertAddressDto
{
    public function __construct(
        public string $street,
        public string $number,
        public int $plz,
        public string $city,
    ) {}
}
