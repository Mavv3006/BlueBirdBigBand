<?php

namespace App\View\Components;

use App\DataTransferObjects\SeoMetaDto;
use App\Services\SeoMetaService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SeoHeader extends Component
{
    public SeoMetaDto $seoMetaDto;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->seoMetaDto = SeoMetaService::getSeoMetaDto();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.seo-header');
    }
}
