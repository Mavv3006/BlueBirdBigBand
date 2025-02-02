<?php

namespace App\Exceptions;

use BackedEnum;
use Exception;

class InvalidStateTransitionException extends Exception
{
    public function __construct(string $currentState, string $targetState)
    {
        parent::__construct(sprintf(
            'Der Übergang vom Status "%s" zu "%s" ist nicht erlaubt.',
            $currentState,
            $targetState
        ));
    }

    public static function fromEnumState(BackedEnum $currentState, BackedEnum $targetState): self
    {
        return new InvalidStateTransitionException($currentState->name, $targetState->name);
    }
}
