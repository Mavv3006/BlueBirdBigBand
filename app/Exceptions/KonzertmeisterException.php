<?php

namespace App\Exceptions;

use Exception;

class KonzertmeisterException extends Exception
{
    public static function noEventsFound(): KonzertmeisterException
    {
        return new self('No events found');
    }
}
