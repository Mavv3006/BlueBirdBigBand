<div class="container mx-auto">
    <x-page-sections.concert-listing
        heading="Anstehende Auftritte"
        :type="\App\Enums\ConcertListingType::Upcoming"
        :limit="$limit"/>

    <div class="w-full flex justify-center">
        <x-forms.buttons.call-to-action-button-button wire:click="increaseLimit" name="Mehr laden"/>
    </div>
</div>
