<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Link extends Component
{
    public function __construct(public string $href)
    {
    }

    public function render(): string
    {
        return <<<'blade'
        <a :href="$href"
           class="border-b-2 border-transparent text-blue-900 transition duration-150 ease-in-out
           hover:border-blue-900 hover:cursor-pointer
           focus:outline-none focus:text-blue-900 focus:border-blue-900">
             {{ $slot }}
        </a>
        blade;
    }
}
