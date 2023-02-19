<template>
    <public-layout>
        <Head><title>Auftritte</title></Head>

        <Heading>Auftritte</Heading>

        <div v-if="hasConcerts" class="flex flex-col gap-4">
            <Concert v-for="concert in displayList" :concert="concert"/>
        </div>

        <p v-if="!hasConcerts" class="text-justify">
            Aktuell sind keine Konzerte geplant.
        </p>
    </public-layout>
</template>

<script lang="ts" setup>
import {Head} from '@inertiajs/vue3';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {computed} from 'vue';
import Concert, {ConcertType} from "@/Components/Concert.vue";

const concert: ConcertType = {
    band: "Blue Bird Big Band",
    date: '2023-12-01',
    description: {
        place: 'bla bla bla?',
        organizer: 'hi hi hi'
    },
    end_time: '16:11:15',
    start_time: '14:10:23',
    address: {
        city: 'Sprockhövel',
        plz: 12345,
        number: '12a',
        street: 'Schusterweg'
    }
};

const emptyConcertList: ConcertType[] = [];
const concertList: ConcertType[] = [concert, concert, concert];

const displayList: ConcertType[] = emptyConcertList;

const hasConcerts = computed<boolean>(() => displayList.length > 0)

</script>

<style scoped>

</style>
