<?php

namespace App\Services\Musician;

use App\Http\Requests\MusicianRequest;
use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class MusicianService
{

    public function activeMusicians(): Collection
    {
        return Instrument::all()->map(fn(Instrument $instrument) => [
            'instrument' => $instrument,
            'musicians' => $instrument->musicians()->get()
        ]);
    }

    public function all(): Collection
    {
        return Musician::with('instrument')
            ->orderBy('instrument_id')
            ->get();
    }

    public function create(MusicianRequest $request): Musician
    {
        $data = $request->validated();
        Log::debug('validated data', [$data]);
        return Musician::create($data);
    }

    public function update(MusicianRequest $request): void
    {
        $data = $request->validated();
        Log::debug('validated data', [$data]);
        Musician::update($data);
    }

    public function instrumentOfMusician(Musician $musician): Instrument
    {
        return $musician
            ->instrument()
            ->get()
            ->first();
    }

    public function delete(Musician $musician): void
    {
        $musician->delete();
    }
}
