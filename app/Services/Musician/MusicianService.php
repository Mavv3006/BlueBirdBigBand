<?php

namespace App\Services\Musician;

use App\Http\Requests\MusicianRequest;
use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;

class MusicianService
{
    public function activeMusicians(): BaseCollection
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
        return Musician::create(
            $request->validated()
        );
    }

    public function update(MusicianRequest $request, Musician $musician): bool
    {
        return $musician->update(
            $request->validated()
        );
    }

    public function delete(Musician $musician): bool|null
    {
        return $musician->delete();
    }
}
