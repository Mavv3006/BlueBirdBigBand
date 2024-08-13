<?php

namespace App\View\Components\Layouts;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FooterHeading extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|\Closure|string
    {
        return <<<'blade'
<p class="text-[#262626] font-semibold">
        {{ $slot }}
</p>
blade;
    }
}
