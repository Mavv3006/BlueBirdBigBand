<div class="w-80 h-64 shadow-xl px-8 pt-5">
    <div class="text-[#262626] font-semibold">{{ $concert->description->event }}</div>
    <div class="text-primary text-xl font-bold">@{{ useFormatDate( }}</div>
    <div class="text-[#575757]">{{ $concert->start_time }} Uhr - {{ $concert->end_time }} Uhr</div>
    <div class="text-[#575757] mt-3">
        <div>{{ $concert->description->venue }}</div>
        <div>{{ $concert->address->street }} {{ $concert->address->number }},</div>
        <div>{{ $concert->address->plz }} {{ $concert->address->city }}</div>
    </div>
    <div class="flex justify-center mt-3">
        <CallToActionButton :href="`/v2/auftritt/${data.id}`" as="anchor" name="Details"/>
    </div>
</div>

<script lang="ts">

    // TODO: fix
    function useFormatDate(date: string): string {
        return new Date(date).toLocaleDateString(
            'de-DE',
            {
                weekday: 'long',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }
        )
    }
</script>
