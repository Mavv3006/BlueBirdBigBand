<div class="mt-8">
    <x-page-sections.section-header>
        Musiker der Blue Bird Big Band
    </x-page-sections.section-header>

    {{ $activeMusicians }}

    <hr class="my-8">

    <div>
        @foreach($activeMusicians as $entry)
            <div class="mt-4">
                <h1 class="">{{ $entry['instrument']['name'] }}</h1>

                <div>
                    @foreach($entry['musicians'] as $musician)
                        {{ $musician['firstname'] }} {{ $musician['lastname'] }}
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
