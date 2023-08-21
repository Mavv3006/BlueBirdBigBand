<?php

namespace App\View\Components\PageSections;

use App\Services\Concert\ConcertService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UpcomingConcertList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ConcertService $concertService)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-sections.upcoming-concert-list', [
            'upcomingConcerts' => $this->concertService->upcoming(3, true),
        ]);
    }
}
