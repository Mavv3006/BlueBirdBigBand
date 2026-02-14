<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UpcomingConcertsResource;
use App\Models\Concert;
use App\Services\Concert\ConcertService;
use Carbon\Carbon;

class UpcomingConcertsController extends Controller
{
    public function __construct(public ConcertService $service)
    {
    }

    public function __invoke()
    {
        $concerts = Concert::with(['band', 'venue'])
            ->whereDate('start_at', '>=', Carbon::today()->toDateString())
            ->orderBy('start_at')
            ->get();

        return UpcomingConcertsResource::collection($concerts);
    }
}
