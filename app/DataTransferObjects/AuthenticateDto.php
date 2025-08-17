<?php

namespace App\DataTransferObjects;

readonly class AuthenticateDto
{
    public function __construct(
        public string $name,
        public string $password,
    ) {}
}
