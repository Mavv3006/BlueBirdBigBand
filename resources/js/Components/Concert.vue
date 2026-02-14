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
import dayjs from 'dayjs';
import 'dayjs/locale/de';

dayjs.locale('de');

const props = defineProps<{ concert: Concert }>();

const start_time = dayjs(props.concert.start_at).format('HH:mm');
const end_time = dayjs(props.concert.end_at).format('HH:mm');
const day = dayjs(props.concert.end_at).format('dddd, DD.MM.YYYY');

const playTime = `${start_time} Uhr - ${end_time} Uhr | ${props.concert.description.event}`;

const venueDescription = !props.concert.description.venue ? "" : `${props.concert.description.venue}, `;

const streetNumber = !props.concert.address.street
    ? ""
    : `${props.concert.address.street} ${props.concert.address.number}, `;

const address = `${venueDescription} ${streetNumber} ${props.concert.address.plz} ${props.concert.address.city}`;
</script>
