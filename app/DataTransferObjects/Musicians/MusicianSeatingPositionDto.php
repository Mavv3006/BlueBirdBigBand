<?php

namespace App\DataTransferObjects\Musicians;

use App\DataTransferObjects\IdDto;

readonly class MusicianSeatingPositionDto
{
    /**
     * @param IdDto[] $musicians
     */
    public function __construct(
        public int $instrument_id,
        public array $musicians
    ) {}
}
