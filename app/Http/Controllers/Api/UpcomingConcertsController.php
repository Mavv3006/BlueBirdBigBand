<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Concert\ConcertService;

class UpcomingConcertsController extends Controller
{
    public function __construct(public ConcertService $service) {}

    public function __invoke()
    {
        return $this->service->upcoming();
    }
}
