<?php

namespace App\Http\Controllers\Admin\MusicianManagement;

use App\DataTransferObjects\UpdateMusicianSeatingPositionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\MusicianSeatingPositionRequest;
use App\Services\Musician\MusicianService;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class MusicianSeatingPositionController extends Controller
{
    public function __construct(public MusicianService $musicianService)
    {
    }

    public function show(): Response
    {
        $activeMusicians = $this->musicianService->activeMusicians();
        Log::debug($activeMusicians->toJson());
        return Inertia::render(
            'Admin/MusicianManagement/SeatingPosition',
            ['data' => $activeMusicians]
        );
    }

    public function update(MusicianSeatingPositionRequest $request)
    {
        $dto = UpdateMusicianSeatingPositionDto::fromRequest($request);
        $this->musicianService->updateSeatingPosition($dto);
        return response()->redirectTo(route('musicians.index'));
    }
}
