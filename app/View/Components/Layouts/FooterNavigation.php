<?php

namespace App\View\Components\Layouts;

use App\Services\View\NavigationLinksService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FooterNavigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.footer-navigation');
    }
}
