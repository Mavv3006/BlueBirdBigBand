<?php

namespace App\Services\Musician;

use App\DataTransferObjects\Musicians\UpdateMusicianSeatingPositionDto;
use App\DataTransferObjects\UpdateMusicianSeatingPositionDto;
use App\Http\Requests\MusicianRequest;
use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        if ($musician->picture_filepath != null) {
            Log::info('Deleting picture of musician', [$musician]);
            Storage::delete($musician->picture_filepath);
        }
        Log::info('Deleting musician', [$musician]);
        return $musician->delete();
    }

    public function updateSeatingPosition(UpdateMusicianSeatingPositionDto $dto): void
    {
        foreach ($dto->data as $instrument) {
            $musicians = $instrument->musicians;
            for ($i = 0; $i < sizeof($musicians); $i++) {
                $musician = Musician::find($musicians[$i]->id);
                if ($musician->seating_position == $i) continue;
                $musician->update(['seating_position' => $i]);
            }
        }
    }

    public function store(MusicianRequest $request): Musician
    {
        $musician = Musician::create($this->getMusicianData($request));
        Log::info('Created a new musician', [$musician]);
        return $musician;
    }

    public function update(MusicianRequest $request, Musician $musician): void
    {
        $musician->update($this->getMusicianData($request));
        Log::info('Updated musician', [$musician]);
    }

    public function deletePicture(Musician $musician): void
    {
        Log::info('Deleting picture of musician after API call', [$musician]);
        if ($musician->picture_filepath != null) {
            Storage::delete($musician->picture_filepath);
        }
        $musician->update(['picture_filepath' => null]);
    }

    private function getMusicianData(MusicianRequest $request): mixed
    {
        $data = $request->validated();
        Log::debug('validated data', [$data]);
        if ($request->file('picture') != null) {
            $picture_path = $request
                ->file('picture')
                ->store('musician_pictures', 'public');
            Log::debug('picture path:' . $picture_path);
            $data['picture_filepath'] = $picture_path;
        }
        return $data;
    }
}
