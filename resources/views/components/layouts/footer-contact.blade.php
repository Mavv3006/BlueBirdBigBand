<div>
    <x-layouts.footer-heading>Kontakt</x-layouts.footer-heading>

    <div class="flex flex-col gap-2 mt-2">
        @foreach($contactLinks as $link)
            <x-layouts.footer-link href="{{ $link->link }}">
                <i class="fa-solid {{ $link->icon }}"></i>
                <span class="hover:underline">{{ $link->name }}</span>
            </x-layouts.footer-link>
        @endforeach
    </div>
</div>
