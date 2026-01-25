<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UpcomingConcertsResource;
use App\Models\Concert;
use App\Services\Concert\ConcertService;

class UpcomingConcertsController extends Controller
{
    public function __construct(public ConcertService $service) {}

    public function __invoke()
    {
        //        $concerts = $this->service->upcoming();
        return Concert::first()->toResource(UpcomingConcertsResource::class);
    }
}
