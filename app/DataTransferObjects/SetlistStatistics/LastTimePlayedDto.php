<?php

namespace App\DataTransferObjects\SetlistStatistics;

use Carbon\Carbon;

readonly class LastTimePlayedDto
{
    public function __construct(
        public int    $id,
        public string $arranger,
        public string $title,
        public Carbon $lastPlayedDate,
    ) {}
}
