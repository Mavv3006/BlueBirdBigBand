<?php

namespace App\Services\Venue;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Collection;

class VenueService
{
    public function all(): Collection
    {
        return Venue::select(['plz', 'name'])
            ->orderBy('plz')
            ->get();
    }
}
