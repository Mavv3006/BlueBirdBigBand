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

export type ConcertType = {
    date: string,
    start_time: string,
    end_time: string,
    address: {
        street: string,
        city: string,
        plz: number,
        number: string
    },
    band: string,
    description: {
        event: string,
        venue: string
    }
};

const props = defineProps<{ concert: ConcertType }>();

const playTime = computed<string>(() => {
    return props.concert.start_time + ' Uhr - '
        + props.concert.end_time + ' Uhr | '
        + props.concert.description.event
});

const address = computed<string>(() => {
    return props.concert.description.venue + ', '
        + props.concert.address.street + ' '
        + props.concert.address.number + ', '
        + props.concert.address.plz + ' '
        + props.concert.address.city;
});

const day = computed<string>(() => {
    return new Date(props.concert.date).toLocaleDateString(
        'de-DE',
        {
            weekday: 'long',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        }
    )
});

</script>

<style scoped>

</style>
