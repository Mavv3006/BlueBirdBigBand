<?php

namespace App\DataTransferObjects\SetlistStatistics;

class SetlistCountDto
{
    public function __construct(
        public readonly int $song_id,
        public readonly int $count
    ) {
    }
}
