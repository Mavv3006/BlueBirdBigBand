<template>
    <PublicLayout page-title="Repertoire">

        <Heading>Repertoire</Heading>

        <div>
            <div v-for="song in repertoire">{{ song.title }}</div>
        </div>

    </PublicLayout>
</template>

<script setup lang="ts">
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
