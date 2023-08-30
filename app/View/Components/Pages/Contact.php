<?php

namespace App\View\Components\Pages;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Contact extends Component
{
    public function render(): View
    {
        return view('components.pages.contact');
    }
}
