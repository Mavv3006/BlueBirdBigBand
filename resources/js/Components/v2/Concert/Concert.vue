<template>
    <div class="w-80 h-64 shadow-xl px-8 pt-5">
        <div class="text-[#262626] font-semibold">{{ data.description.event }}</div>
        <div class="text-primary text-xl font-bold">{{ useFormatDate(data.date) }}</div>
        <div class="text-[#575757]">{{ data.start_time }} Uhr - {{ data.end_time }} Uhr</div>
        <div class="text-[#575757] mt-3">
            <div>{{ data.description.venue }}</div>
            <div>{{ data.address.street }} {{ data.address.number }},</div>
            <div>{{ data.address.plz }} {{ data.address.city }}</div>
        </div>
        <div class="flex justify-center mt-3">
            <CallToActionButton :href="`/v2/auftritt/${data.id}`" as="anchor" name="Details"/>
        </div>
    </div>
</template>

<script setup lang="ts">
import {Concert as ConcertType} from "@/types/concert";
import CallToActionButton from "@/Components/v2/CallToActionButton.vue";
import {useFormatDate} from "@/Composables/useFormatDate";

defineProps<{ data: ConcertType }>();
</script>

<style scoped>

</style>
