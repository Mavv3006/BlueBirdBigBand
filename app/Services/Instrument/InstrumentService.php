<?php

namespace App\Services\Instrument;

use App\Models\Instrument;
use Illuminate\Database\Eloquent\Collection;

class InstrumentService
{
    public function all(): Collection
    {
        return Instrument::all();
    }
}
