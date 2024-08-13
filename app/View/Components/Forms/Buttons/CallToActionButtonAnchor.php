<?php

namespace App\View\Components\Forms\Buttons;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CallToActionButtonAnchor extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $href,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|\Closure|string
    {
        return view('components.forms.buttons.call-to-action-button-anchor', [
            'name' => $this->name,
            'href' => $this->href,
        ]);
    }
}
