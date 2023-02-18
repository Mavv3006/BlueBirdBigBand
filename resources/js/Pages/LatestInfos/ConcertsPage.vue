<template>
    <public-layout>
        <Head><title>Auftritte</title></Head>

        <Heading>Auftritte</Heading>

        <div class="flex flex-col gap-4" v-if="hasConcerts">
            <Concert :concert="concert"/>
        </div>

        <p v-if="!hasConcerts" class="text-justify">
            Aktuell sind keine Konzerte geplant.
        </p>
    </public-layout>
</template>

<script setup lang="ts">
import {Head} from '@inertiajs/vue3';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {computed} from 'vue';
import Concert, {ConcertType} from "@/Components/Concert.vue";

const hasConcerts = computed<boolean>(() => true)

const concert: ConcertType = {
    band: "Blue Bird Big Band",
    date: '2023-12-01',
    description: {
        place: 'test',
        organizer: 'test'
    },
    end_time: '12',
    start_time: '14',
    address: {
        city: 'Test',
        plz: 12345,
        number: '12a',
        street: 'test'
    }
};

</script>

<style scoped>

</style>
