<x-layouts.public-layout title="Nur ein Konzert">
    <div class="container mx-auto mt-8">
        <x-page-sections.section-header>
            Auftritt vom {{ $concert->date->locale('de')->isoFormat('DD.MM.Y') }} in {{ $concert->address->city }}
        </x-page-sections.section-header>

        <div class="flex gap-12 mt-4">

            <div class="h-96 w-80 bg-gray-300 flex justify-center items-center">
                <p class="text-center">
                    Dies ist ein Platzhalter für ein Bild vom Auftritt.
                </p>
            </div>

            <div>
                <p>
                    Wann? {{ $concert->date->locale('de')->isoFormat('dddd, DD.MM.Y') }}
                    von {{ $concert->start_time->format('H:i') }} Uhr bis {{ $concert->end_time->format('H:i') }} Uhr
                </p>
                <p>
                    Wo? {{ $concert->description->venue }} in {{ $concert->address->city }}
                </p>
            </div>

        </div>

        @if( sizeof($setlistSongs) > 0)
            <div class="mt-8">
                <x-concert.setlist :setlistSongs="$setlistSongs" bandName="{{$concert->band}}"/>
            </div>
        @endif
    </div>

</x-layouts.public-layout>
