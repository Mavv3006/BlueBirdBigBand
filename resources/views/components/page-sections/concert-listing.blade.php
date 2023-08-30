<div>
    <div class="mx-auto container">
        <x-page-sections.section-header class="pb-4">
            {{ $heading }}
        </x-page-sections.section-header>

        <div class="flex flex-col items-center gap-x-4 gap-y-8
                md:flex-row md:flex-wrap md:justify-center
                lg:gap-x-8
                xl:gap-x-16 xl:justify-evenly">
            @foreach($listOfConcerts as $concert)
                <x-concert :concert="$concert"/>
            @endforeach
        </div>
    </div>
</div>
