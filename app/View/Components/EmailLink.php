<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmailLink extends Component
{
    public function __construct(public string $mailAddress)
    {
    }

    public function render(): string
    {
        return <<<'blade'
        <a href="mailto:{{ $mailAddress }}"
           class="border-b-2 border-transparent text-blue-900 transition duration-150 ease-in-out
           hover:border-blue-900
           focus:outline-none focus:text-blue-900 focus:border-blue-900">
            {{ $mailAddress }}
        </a>
        blade;
    }
}
