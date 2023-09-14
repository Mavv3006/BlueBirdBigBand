<template>
    <div>
        <div class="font-semibold underline">{{ concert.band }}</div>
        <div class="font-semibold">{{ day }}</div>
        <div>{{ playTime }}</div>
        <div>{{ address }}</div>
    </div>
</template>

<script lang="ts" setup>
import {defineProps} from 'vue';
import {Concert} from "@/types/concert";
import {useFormatDate} from "@/Composables/useFormatDate";

const props = defineProps<{ concert: Concert }>();

const playTime = `${props.concert.start_time} Uhr - ${props.concert.end_time} Uhr | ${props.concert.description.event}`;

const venueDescription = !props.concert.description.venue ? "" : `${props.concert.description.venue}, `;

const streetNumber = !props.concert.address.street
    ? ""
    : `${props.concert.address.street} ${props.concert.address.number}, `;

const address = `${venueDescription} ${streetNumber} ${props.concert.address.plz} ${props.concert.address.city}`;

const day = useFormatDate(props.concert.date);

</script>

<style scoped>

</style>
