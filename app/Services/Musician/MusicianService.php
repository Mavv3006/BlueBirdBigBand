<?php

namespace App\Services\Musician;

use App\DataTransferObjects\Musicians\UpdateMusicianSeatingPositionDto;
use App\Http\Requests\MusicianRequest;
use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MusicianService
{
    /**
     * @return array{
     *     instrument: array{
     *         name: string,
     *         id: int,
     *         order: int,
     *         default_picture_filepath: string,
     *         tux_filepath: string,
     *     },
     *     musicians: array{
     *         id: int,
     *         instrument_id: int,
     *         firstname: string,
     *         lastname: string,
     *         seating_position: int,
     *         picture_filepath: string|null
     *     }
     * }
     */
    public function activeMusicians(): array
    {
        $instruments = Instrument::with('musicians')
            ->whereNotNull('order')
            ->orderBy('order')
            ->get();

        return collect($instruments)
            ->map(fn (Instrument $instrument) => [
                'instrument' => [
                    'id' => $instrument->id,
                    'name' => $instrument->name,
                    'default_picture_filepath' => $instrument->default_picture_filepath,
                    'order' => $instrument->order,
                    'tux_filepath' => $instrument->tux_filepath,
                ],
                'musicians' => $this->getMusiciansForInstrument($instrument),
            ])
            ->values()
            ->toArray();
    }

    public function all(): Collection
    {
        return Musician::with('instrument')
            ->orderBy('instrument_id')
            ->get();
    }

    public function delete(Musician $musician): ?bool
    {
        if ($musician->picture_filepath != null) {
            Log::info('Deleting picture of musician', [$musician]);
            Storage::delete($musician->picture_filepath);
        }
        Log::info('Deleting musician', [$musician]);

        return $musician->delete();
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
            Log::debug('picture path:'.$picture_path);
            $data['picture_filepath'] = $picture_path;
        }

        return $data;
    }

    /**
     * @return array{
     *     id: int,
     *     instrument_id: int,
     *     firstname: string,
     *     lastname: string,
     *     seating_position: int,
     *     picture_filepath: string|null
     * }
     */
    protected function getMusiciansForInstrument(Instrument $instrument): array
    {
        return collect($instrument->musicians)
            ->filter(fn (Musician $musician) => $musician->isActive)
            ->map(fn (Musician $musician) => [
                'id' => $musician->id,
                'instrument_id' => $musician->instrument_id,
                'firstname' => $musician->firstname,
                'lastname' => $musician->lastname,
                'seating_position' => $musician->seating_position,
                'picture_filepath' => $musician->picture_filepath,
            ])
            ->sortBy('firstname')
            ->values()
            ->toArray();
    }
}
