<?php

namespace App\DataTransferObjects;

readonly class IdDto
{
    public function __construct(public int $id) {}
}
