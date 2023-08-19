<?php

namespace App\DataTransferObjects\Concerts;

class ConcertAddressDto
{
    public function __construct(
        public readonly string $street,
        public readonly string $number,
        public readonly int    $plz,
        public readonly string $city,
    )
    {
    }
}
