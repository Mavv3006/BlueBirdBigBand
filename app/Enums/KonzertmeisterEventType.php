<?php

namespace App\Enums;

enum KonzertmeisterEventType: string
{
    case Probe = 'Probe';
    case Auftritt = 'Auftritt';
    case Sonstiges = 'Sonstiges';

    public static function fromIcal(string $icalDescription): self
    {
        $descriptionArray = explode(' ', $icalDescription);
        return match ($descriptionArray[0]) {
            'Probe' => self::Probe,
            'Auftritt' => self::Auftritt,
            'Sonstiges' => self::Sonstiges,
        };
    }
}
