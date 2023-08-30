<template>
    <PublicLayout>
        <Heading>Konzert erstellen</Heading>
        <Head><title>Konzert erstellen</title></Head>

        <ConcertCreationForm :venues="venues" :bands="bands"/>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from '@inertiajs/vue3';
import {Band, Venue} from "@/types/concert";
import ConcertCreationForm from "@/Components/Forms/ConcertCreationForm.vue";

const props = defineProps<{
    venues: Venue[],
    bands: Band[]
}>();

</script>

