<?php

namespace App\DataTransferObjects\SetlistStatistics;

use Carbon\Carbon;

class LastTimePlayedDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $arranger,
        public readonly string $title,
        public readonly Carbon $lastPlayedDate,
    ) {}
}
