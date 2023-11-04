<?php

namespace App\Http\Controllers;

use App\Enums\FeatureFlagName;
use App\Services\Concert\ConcertService;
use App\Services\FeatureFlag\FeatureFlagService;
use App\Services\Musician\MusicianService;
use Inertia\Inertia;
use Inertia\Response;

class PublicController extends Controller
{
    public function __construct(
        public ConcertService  $concertService,
        public MusicianService $musicianService,
    )
    {
    }

    public function home(): Response
    {
        return Inertia::render('Index');
    }

    public function aboutUs(): Response
    {
        return Inertia::render('Band/AboutPage');
    }

    public function arrival(): Response
    {
        return Inertia::render('Band/ArrivalPage');
    }

    public function concerts(): Response
    {
        return Inertia::render('LatestInfos/ConcertsPage', [
            'concerts' => $this->concertService->upcoming(),
        ]);
    }

    public function booking(): Response
    {
        return Inertia::render('LatestInfos/BookingPage');
    }

    public function imprint(): Response
    {
        return Inertia::render('Contact/ImprintPage');
    }

    public function contact(): Response
    {
        return Inertia::render('Contact/ContactPage');
    }

    public function pressInfo(): Response
    {
        return Inertia::render('LatestInfos/PressInfoPage');
    }

    public function musicians(): Response
    {
        $musicians = $this->musicianService->activeMusicians();
        if (FeatureFlagService::isOn(FeatureFlagName::NewMusicianPage)) {
            return Inertia::render('Band/NewMusiciansPage', [
                'data' => $musicians,
            ]);
        }

        return Inertia::render('Band/MusiciansPage', [
            'data' => $musicians,
        ]);
    }
}
