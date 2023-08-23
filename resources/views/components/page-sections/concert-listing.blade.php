<div class="bg-white">
    <div class="mx-auto">
        <x-page-sections.section-header class="pl-16 pt-8 pb-4">
            {{ $heading }}
        </x-page-sections.section-header>

        <div class="flex flex-col items-center gap-8 pb-16
                md:flex-row md:flex-wrap md:justify-center
                lg:mx-8 lg:gap-x-16
                xl:justify-evenly">
            @foreach($listOfConcerts as $concert)
                <x-concert :concert="$concert"/>
            @endforeach
        </div>
    </div>
</div>
