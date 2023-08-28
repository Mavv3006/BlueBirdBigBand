<x-layouts.public-layout title="Hello World">
    <x-page-sections.hero/>

    <div class="flex gap-8 flex-col mt-8">
    <x-page-sections.concert-listing
        heading="Unsere nächsten Auftritte"
        :type="\App\Enums\ConcertListingType::Upcoming"
        limit="3"/>

    <x-page-sections.about/>
    </div>

</x-layouts.public-layout>
