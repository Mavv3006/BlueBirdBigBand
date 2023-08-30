<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Contact extends Component
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $telephone = null,
        public ?string $telefax = null,
        public ?string $mobile = null,
        public bool $boldName = false
    ) {
    }

    public function render(): View
    {
        return view('components.contact');
    }
}
