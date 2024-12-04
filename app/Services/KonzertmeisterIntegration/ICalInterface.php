<?php

namespace App\Services\KonzertmeisterIntegration;

interface ICalInterface
{
    public function events(): array;

    public function setup(): self;
}
