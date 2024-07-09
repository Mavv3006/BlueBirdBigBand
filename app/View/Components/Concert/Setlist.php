<?php

namespace App\View\Components\Concert;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Setlist extends Component
{
    public function __construct(public Collection $setlistSongs, public string $bandName) {}

    public function render(): View
    {
        return view('components.concert.setlist');
    }
}
