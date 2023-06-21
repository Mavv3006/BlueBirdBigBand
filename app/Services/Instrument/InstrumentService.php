<?php

namespace App\Services\Instrument;

use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Database\Eloquent\Collection;

class InstrumentService
{
    public function all(): Collection
    {
        return Instrument::all();
    }

    public function fromMusician(Musician $musician): Instrument
    {
        return $musician
            ->instrument()
            ->get()
            ->first();
    }
}
