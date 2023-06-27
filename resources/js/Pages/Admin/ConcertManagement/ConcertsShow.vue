<template>
    <PublicLayout>
        <Heading>Konzert anzeigen</Heading>
        <Head><title>Konzert anzeigen</title></Head>

        <Concert :concert="concert"/>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from '@inertiajs/vue3';
import Concert, {ConcertType} from "@/Components/Concert.vue";

const props = defineProps<{
    concert: ConcertType
}>();
</script>

<style scoped>

</style>
