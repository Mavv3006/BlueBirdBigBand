<?php

namespace App\View\Components;

use App\DataTransferObjects\Concerts\FormattedConcertDto;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Concert extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public FormattedConcertDto $concert)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.concert', [
            'concert' => $this->concert
        ]);
    }
}
