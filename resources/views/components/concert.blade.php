<div class="w-80 h-64 shadow-xl px-8 pt-5">
    <div class="text-[#262626] font-semibold">{{ $concert->description->event }}</div>
    <div class="text-primary text-xl font-bold">{{ $concert->date->locale('de')->isoFormat('dddd, DD.MM.Y') }}</div>
    <div class="text-[#575757]">{{ $concert->start_time->format('H:i') }} Uhr - {{ $concert->end_time->format('H:i') }}
        Uhr
    </div>
    <div class="text-[#575757] mt-3">
        <div>{{ $concert->description->venue }}</div>
        <div>{{ $concert->address->street }} {{ $concert->address->number }},</div>
        <div>{{ $concert->address->plz }} {{ $concert->address->city }}</div>
    </div>
    <div class="flex justify-center mt-3">
        <x-forms.buttons.call-to-action-button-anchor href="`/v2/auftritt/{{$concert->id}}`" as="anchor"
                                                      name="Details"/>
    </div>
</div>
