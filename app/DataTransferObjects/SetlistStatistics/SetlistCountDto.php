<?php

namespace App\DataTransferObjects\SetlistStatistics;

class SetlistCountDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $arranger,
        public readonly string $title,
        public readonly int $count
    ) {}
}
