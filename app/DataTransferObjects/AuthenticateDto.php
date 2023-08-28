<?php

namespace App\DataTransferObjects;

class AuthenticateDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $password,
    ) {
    }
}
