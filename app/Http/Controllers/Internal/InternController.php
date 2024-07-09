<?php

namespace App\Http\Controllers\Internal;

use App\DataTransferObjects\SeoMetaDto;
use App\Http\Controllers\Controller;
use App\Services\SeoMetaService;
use App\Services\Song\SongService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Inertia\Inertia;
use Inertia\Response;

class InternController extends Controller
{
    public function __construct(
        public SongService $songService,
    ) {}

    public function index(): Redirector|RedirectResponse|Application
    {
        return redirect(route('home'), 301);
    }

    public function emails(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'E-Mail Verteiler',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('Intern/Emails');
    }

    public function songs(): Response
    {
        SeoMetaService::setSeoMetaDto(new SeoMetaDto(
            title: 'Songs',
            description: 'Homepage der Blue Bird Big Band - hier finden sie Infos und die aktuellen Veranstaltungstermine der Blue Bird Bigband der Musikschule Speyer'
        ));

        return Inertia::render('Intern/Songs', [
            'songs' => $this->songService->all(),
        ]);
    }
}
