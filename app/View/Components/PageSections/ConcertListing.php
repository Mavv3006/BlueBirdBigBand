<?php

namespace App\View\Components\PageSections;

use App\Enums\ConcertListingType;
use App\Services\Concert\ConcertService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConcertListing extends Component
{
    public function __construct(
        public string $heading,
        public ConcertListingType $type,
        public int $limit,
        public ConcertService $concertService,
    ) {
    }

    public function render(): View
    {
        $listOfConcerts = match ($this->type) {
            ConcertListingType::Upcoming => $this->concertService->upcoming($this->limit, true),
            ConcertListingType::Past => $this->concertService->past($this->limit, true),
        };

        \Log::debug('rendering "components.page-sections.concert-listing"', [
            'limit' => $this->limit,
            'type' => $this->type->value,
        ]);

        return view('components.page-sections.concert-listing', [
            'listOfConcerts' => $listOfConcerts,
        ]);
    }
}
