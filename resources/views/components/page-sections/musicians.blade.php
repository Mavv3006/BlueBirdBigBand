<div class="mt-8">
    <x-page-sections.section-header>
        Musiker der Blue Bird Big Band
    </x-page-sections.section-header>

    <div class="flex flex-wrap">
        @foreach($bandleaderPlusVocals as $entry)
            <div class="mt-4 lg:w-1/5">
                <h1 class="">{{ $entry['instrument']['name'] }}</h1>

                <div class="flex flex-col pl-6">
                    @foreach($entry['musicians'] as $musician)
                        <div>
                            {{ $musician['firstname'] }} {{ $musician['lastname'] }}
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex flex-wrap">
        @foreach($instrumentalists as $entry)
            <div class="mt-4 lg:w-1/5">
                <h1 class="">{{ $entry['instrument']['name'] }}</h1>

                <div class="flex flex-col pl-6">
                    @foreach($entry['musicians'] as $musician)
                        <div>
                            {{ $musician['firstname'] }} {{ $musician['lastname'] }}
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
