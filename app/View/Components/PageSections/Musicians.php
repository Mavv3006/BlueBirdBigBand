<?php

namespace App\View\Components\PageSections;

use App\Services\Musician\MusicianService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Musicians extends Component
{
    public function __construct(public MusicianService $musicianService)
    {
    }

    public function render(): View
    {
        //        dd($this->musicianService->activeMusicians());
        return view('components.page-sections.musicians', [
            'activeMusicians' => $this->musicianService->activeMusicians(),
        ]);
    }
}
