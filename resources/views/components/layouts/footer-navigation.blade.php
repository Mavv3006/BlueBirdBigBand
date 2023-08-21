@inject('navLinks','App\Services\View\NavigationLinksService')

<div>
    <x-layouts.footer-heading>Navigation</x-layouts.footer-heading>

    <div class="flex flex-col gap-2 mt-2">
        @foreach($navLinks->getLinkNavElements() as $link)
            <x-layouts.footer-link href="hi">{{ $link->name }}</x-layouts.footer-link>
        @endforeach
    </div>
</div>
