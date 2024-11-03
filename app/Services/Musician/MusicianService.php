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
     *     instrument: array {
     *         name: string,
     *         id: numeric,
     *         filepath: string,
     *     },
     *     musicians: array { string }
     * }
     */
    public function activeMusicians(): array
    {
        $instruments = Instrument::with('musicians')
            ->whereNotNull('order')
//            ->select('id', 'name', 'default_picture_filepath')
            ->orderBy('order')
            ->get();

        $return = [];

        //        foreach ($instruments as $instrument) {
        //            $instrumentObject = [
        //                'name' => $instrument->name,
        //                'id' => $instrument->id,
        //                'filepath' => $instrument->default_picture_filepath,
        //            ];
        //
        //            $musiciansArray = [];
        //
        //            foreach ($instrument->musicians as $musician) {
        //                $musiciansArray[] = "$musician->firstname $musician->lastname";
        //            }
        //
        //            $return[] = [
        //                'instrument' => $instrumentObject,
        //                'musicians' => $musiciansArray,
        //            ];
        //        }

        foreach ($instruments as $instrument) {
            $instrumentObject = [
                'id' => $instrument->id,
                'name' => $instrument->name,
                'default_picture_filepath' => $instrument->default_picture_filepath,
                'order' => $instrument->order,
                'tux_filepath' => $instrument->tux_filepath,
            ];

            $musiciansObject = [];

            foreach ($instrument->musicians as $musician) {
                if (!$musician->isActive) {
                    continue;
                }

                $musiciansObject[] = [
                    'id' => $musician->id,
                    'instrument_id' => $musician->instrument_id,
                    'firstname' => $musician->firstname,
                    'lastname' => $musician->lastname,
                    'seating_position' => $musician->seating_position,
                    'picture_filepath' => $musician->picture_filepath,
                ];
            }

            $musiciansObject = collect($musiciansObject)
                ->sortBy('firstname')
                ->values()
                ->all();

            $return[] = [
                'instrument' => $instrumentObject,
                'musicians' => $musiciansObject,
            ];
        }

        return $return;
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

    public function updateSeatingPosition(UpdateMusicianSeatingPositionDto $dto): void
    {
        foreach ($dto->data as $instrument) {
            $musicians = $instrument['musicians'];
            for ($i = 0; $i < count($musicians); $i++) {
                $musician = Musician::find($musicians[$i]['id']);
                if ($musician->seating_position == $i) {
                    continue;
                }
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
            Log::debug('picture path:'.$picture_path);
            $data['picture_filepath'] = $picture_path;
        }

        return $data;
    }
}
