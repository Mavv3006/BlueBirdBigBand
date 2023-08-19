<?php

namespace App\View\Components\Layouts;

use App\DataTransferObjects\View\FooterContactLinkDto;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FooterContact extends Component
{
    /**
     * @var FooterContactLinkDto[]
     */
    private array $contactLinks;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->contactLinks = [
            new FooterContactLinkDto(
                name: "Mausbergweg 144, 67346 Speyer", icon: 'fa-location-dot', link: '',
            ),
            new FooterContactLinkDto(
                name: "0171 5808481", icon: 'fa-phone', link: 'tel:01715808481',
            ),
            new FooterContactLinkDto(
                name: "buchung@bluebirdbigband.de", icon: 'fa-envelope', link: 'mailto:buchung@bluebirdbigband.de',
            ),
            new FooterContactLinkDto(
                name: "bandleiter@bluebirdbigband.de", icon: 'fa-envelope', link: 'mailto:bandleiter@bluebirdbigband.de',
            ),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.footer-contact', [
            'contactLinks' => $this->contactLinks
        ]);
    }
}
