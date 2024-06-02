<template>
    <PublicLayout page-title="Repertoire">

        <Head><title>Repertoire</title></Head>

        <Heading>Repertoire</Heading>

        <div>
            <div v-for="song in repertoire">{{ song.title }}</div>
        </div>

    </PublicLayout>
</template>

<script setup lang="ts">
import {Head} from '@inertiajs/vue3';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";

type RepertoireSong = {
    title: string,
    genre: string,
    arranger: string,
    author: string,
}
const props = defineProps<{ repertoire: RepertoireSong[] }>()
</script>

<style scoped>
</style>
