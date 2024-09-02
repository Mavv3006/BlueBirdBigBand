<?php

namespace App\Enums;

enum BandName: string
{
    case BlueBird = 'Blue Bird Big Band';
    case DomeTown = 'Dometown-Big Band';

    public static function fromString(string $value): self
    {
        return match ($value) {
            self::BlueBird->value => self::BlueBird,
            self::DomeTown->value => self::DomeTown,
        };
    }
}
