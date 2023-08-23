<?php

namespace App\Enums;

enum ConcertListingType: string
{
    case Upcoming = 'upcoming';
    case Past = 'past';
}
