<template>
    <PublicLayout>
        <Heading>Songs</Heading>
        <Head><title>Songs</title></Head>

        <SongList :songs="songs"/>
    </PublicLayout>
</template>

<script setup lang="ts">
import {Head} from '@inertiajs/vue3';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import SongList from "@/Components/SongList.vue";

const props = defineProps<{
    songs: {
        id: number,
        title: string,
        arranger: string,
        author: string,
        genre: string,
        file_path?: string
    }[]
}>();
</script>

