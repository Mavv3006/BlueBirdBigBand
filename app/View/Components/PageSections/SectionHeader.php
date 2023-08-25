<?php

namespace App\View\Components\PageSections;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SectionHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|\Closure|string
    {
        return view('components.page-sections.section-header');
    }
}
