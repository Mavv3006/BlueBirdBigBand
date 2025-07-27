<?php

namespace App\DataTransferObjects\SetlistStatistics;

readonly class SetlistCountDto
{
    public function __construct(
        public int $id,
        public string $arranger,
        public string $title,
        public int $count
    ) {}
}
