<x-layouts.public-layout title="Hello World">
    <x-page-sections.hero/>

    <div class="flex gap-16 flex-col mt-16">
        <x-page-sections.concert-listing
            heading="Unsere nächsten Auftritte"
            :type="\App\Enums\ConcertListingType::Upcoming"
            limit="3"/>

        <x-page-sections.about/>

        <x-page-sections.archivements/>
    </div>

</x-layouts.public-layout>
