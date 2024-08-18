<?php

namespace App\StateMachines\KonzertmeisterEvent;

use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Models\KonzertmeisterEvent;
use Exception;

abstract class BaseKonzertmeisterEventConversionState
{
    public function __construct(public KonzertmeisterEvent $konzertmeisterEvent) {}

    protected function changeStateTo(KonzertmeisterEventConversionState $newState): void
    {
        if ($this->konzertmeisterEvent->conversion_state == $newState) {
            return;
        }

        $this->konzertmeisterEvent->update([
            'conversion_state' => $newState,
        ]);
    }

    /**
     * @throws Exception
     */
    public function reject(): void
    {
        throw new Exception();
    }

    /**
     * @throws Exception
     */
    public function convert(): void
    {
        throw new Exception();
    }
}
