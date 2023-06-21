<?php

namespace App\Http\Controllers\Admin\MusicianManagement;

use App\DataTransferObjects\Musicians\UpdateMusicianSeatingPositionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\MusicianSeatingPositionRequest;
use App\Services\Musician\MusicianService;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class MusicianSeatingPositionController extends Controller
{
    public function __construct(public MusicianService $musicianService)
    {
    }

    public function show(): Response
    {
        Gate::authorize('manage musicians');

        return Inertia::render(
            'Admin/MusicianManagement/SeatingPosition',
            ['data' => $this->musicianService->activeMusicians()]
        );
    }

    public function update(MusicianSeatingPositionRequest $request)
    {
        Gate::authorize('manage musicians');

        $dto = UpdateMusicianSeatingPositionDto::fromRequest($request);
        $this->musicianService->updateSeatingPosition($dto);
        return response()->redirectTo(route('musicians.index'));
    }
}
