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
        $allMusicians = $this->musicianService->activeMusicians();

        return view('components.page-sections.musicians', [
            'instrumentalists' => $allMusicians->splice(2),
            'bandleaderPlusVocals' => $allMusicians->splice(0, 2),
        ]);
    }
}
