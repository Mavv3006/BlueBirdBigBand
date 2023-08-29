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
        <x-link :href="$mailAddress">
            {{ $mailAddress }}
        </x-link>
        blade;
    }
}
