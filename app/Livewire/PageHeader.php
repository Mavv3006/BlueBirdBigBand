<?php

namespace App\Livewire;

use App\Services\View\NavigationLinksService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PageHeader extends Component
{
    public bool $isMobileMenuOpen = false;

    protected NavigationLinksService $linksService;

    public function boot(NavigationLinksService $linksService): void
    {
        $this->linksService = $linksService;
    }

    public function toggleMobileMenu(): void
    {
        $this->isMobileMenuOpen = !$this->isMobileMenuOpen;
    }

    public function render(): View
    {
        return view('livewire.page-header', [
            'navLinks' => $this->linksService,
        ]);
    }
}
