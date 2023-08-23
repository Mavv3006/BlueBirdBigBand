<div class="container mx-auto">
    <x-page-sections.concert-listing
        heading="Vergangene Auftritte"
        :type="\App\Enums\ConcertListingType::Past"
        :limit="$limit"/>

    <div class="w-full flex justify-center">
        <x-forms.buttons.call-to-action-button-button wire:click="increaseLimit" name="Mehr laden"/>
    </div>
</div>
