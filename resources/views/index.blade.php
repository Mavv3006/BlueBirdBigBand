<x-layouts.public-layout title="Hello World">

    <x-page-sections.hero/>

    <x-page-sections.concert-listing heading="Unsere nächsten Auftritte" :type="\App\Enums\ConcertListingType::Upcoming"
                                     limit="3"/>

</x-layouts.public-layout>
