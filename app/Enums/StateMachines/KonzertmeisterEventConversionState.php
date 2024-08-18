<?php

namespace App\Enums\StateMachines;

enum KonzertmeisterEventConversionState: string
{
    case Open = 'open';
    case Rejected = 'rejected';
    case Converted = 'converted';
}
