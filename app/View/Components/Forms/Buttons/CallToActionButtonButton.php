<?php

namespace App\View\Components\Forms\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CallToActionButtonButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $name)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.buttons.call-to-action-button-button', [
            'name' => $this->name,
        ]);
    }
}
