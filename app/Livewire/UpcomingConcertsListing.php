<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class UpcomingConcertsListing extends Component
{
    public int $limit = 3;

    public function render(): View
    {
        return view('livewire.upcoming-concerts-listing');
    }

    public function increaseLimit(): void
    {
        $this->limit += 3;
    }
}
