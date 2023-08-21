<?php

namespace App\DataTransferObjects\Musicians;

use App\DataTransferObjects\IdDto;

class MusicianSeatingPositionDto
{
    /**
     * @param  IdDto[]  $musicians
     */
    public function __construct(
        public readonly int $instrument_id,
        public readonly array $musicians
    ) {
    }
}
