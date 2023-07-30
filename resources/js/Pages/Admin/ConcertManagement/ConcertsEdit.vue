<template>
    <PublicLayout>
        <Heading>Konzert bearbeiten</Heading>
        <Head><title>Konzert bearbeiten</title></Head>

        <ConcertEditingForm :venues="venues" :bands="bands" :concert="concert"/>
    </PublicLayout>
</template>

<script setup lang="ts">
import {Band, Concert, Venue} from "@/types/concert";
import Heading from "@/Components/Heading.vue";
import {Head} from "@inertiajs/vue3";
import PublicLayout from "@/Layouts/PublicLayout.vue";
import ConcertEditingForm from "@/Components/Forms/ConcertEditingForm.vue";

const props = defineProps<{
    venues: Venue[],
    bands: Band[],
    concert: Concert
}>();
</script>

<style scoped>

</style>
