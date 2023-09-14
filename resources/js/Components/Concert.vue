<template>
    <div>
        <div class="font-semibold underline">{{ concert.band }}</div>
        <div class="font-semibold">{{ day }}</div>
        <div>{{ playTime }}</div>
        <div>{{ address }}</div>
    </div>
</template>

<script lang="ts" setup>
import {computed, defineProps} from 'vue';
import {Concert} from "@/types/concert";
import {useFormatDate} from "@/Composables/useFormatDate";

const props = defineProps<{ concert: Concert }>();

console.debug(props.concert)

const playTime = computed<string>(() => {
    return props.concert.start_time + ' Uhr - '
        + props.concert.end_time + ' Uhr | '
        + props.concert.description.event
});

const address = computed<string>(() => {
    return `${venueDescription()} ${streetNumber()} ${props.concert.address.plz} ${props.concert.address.city}`;
});

const venueDescription = () => {
    return !props.concert.description.venue ? "" : `${props.concert.description.venue}, `;
};

const streetNumber = () => {
    return !props.concert.address.street
        ? ""
        : `${props.concert.address.street} ${props.concert.address.number}, `;
};

const day = computed<string>(() => useFormatDate(props.concert.date));

</script>

<style scoped>

</style>
