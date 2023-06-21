<?php

namespace App\Services\Musician;

use App\DataTransferObjects\UpdateMusicianSeatingPositionDto;
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
            'musicians' => $instrument
                ->musicians()
                ->where('isActive', 1)
                ->orderBy('seating_position')
                ->get()
        ]);
    }

    public function all(): Collection
    {
        return Musician::with('instrument')
            ->orderBy('instrument_id')
            ->get();
    }

    public function delete(Musician $musician): bool|null
    {
        return $musician->delete();
    }

    public function updateSeatingPosition(UpdateMusicianSeatingPositionDto $dto): void
    {
        foreach ($dto->data as $instrument) {
            $musicians = $instrument['musicians'];
            for ($i = 0; $i < sizeof($musicians); $i++) {
                $musician = Musician::find($musicians[$i]['id']);
                if ($musician->seating_position == $i) continue;
                $musician->update(['seating_position' => $i]);
            }
        }
    }
}
