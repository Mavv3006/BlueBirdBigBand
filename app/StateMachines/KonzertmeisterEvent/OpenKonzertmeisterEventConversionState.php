<?php

namespace App\StateMachines\KonzertmeisterEvent;

use App\Enums\StateMachines\KonzertmeisterEventConversionState;

class OpenKonzertmeisterEventConversionState extends BaseKonzertmeisterEventConversionState
{
    public function reject(): void
    {
        $this->changeStateTo(KonzertmeisterEventConversionState::Rejected);
    }

    public function convert(): void
    {
        $this->changeStateTo(KonzertmeisterEventConversionState::Converted);
    }
}
