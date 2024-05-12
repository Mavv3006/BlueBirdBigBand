<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\SeoMetaDto;
use App\Services\Concert\ConcertService;
use App\Services\Musician\MusicianService;
use App\Services\SeoMetaService;
use Inertia\Inertia;
use Inertia\Response;

class PublicController extends Controller
{
    public function __construct(
        public ConcertService $concertService,
        public MusicianService $musicianService,
    ) {
    }

    public function home(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Willkommen',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('Index');
    }

    public function aboutUs(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Über uns',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('Band/AboutPage');
    }

    public function arrival(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Anfahrt',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('Band/ArrivalPage');
    }

    public function concerts(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Auftritte',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('LatestInfos/ConcertsPage', [
            'concerts' => $this->concertService->upcoming(),
        ]);
    }

    public function booking(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Buchungsinfos',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('LatestInfos/BookingPage');
    }

    public function imprint(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Impressum',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('Contact/ImprintPage');
    }

    public function contact(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Kontakt',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('Contact/ContactPage');
    }

    public function pressInfo(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Presseinfos',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('LatestInfos/PressInfoPage');
    }

    public function musicians(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Musiker',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('Band/MusiciansPage', [
            'data' => $this->musicianService->activeMusicians(),
        ]);
    }

    public function newsletter()
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Newsletter',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('Contact/Newsletter');
    }
}
