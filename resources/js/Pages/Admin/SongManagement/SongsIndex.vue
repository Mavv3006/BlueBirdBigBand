<template>
    <PublicLayout>
        <Heading>Song Management</Heading>
        <Head><title>Song Management</title></Head>

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
        song_name: string,
        arranger: string,
        author: string,
        genre: string
    }[]
}>();
</script>

