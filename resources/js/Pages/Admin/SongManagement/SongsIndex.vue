<template>
    <PublicLayout>
        <Heading>Song Management</Heading>
        <Head><title>Song Management</title></Head>

        <SongList :songs="songs" show-actions show-id/>

        <div class="flex justify-end mt-4">
            <FloatingActionButton link="songs/create"/>
        </div>
    </PublicLayout>
</template>

<script setup lang="ts">
import {Head} from '@inertiajs/vue3';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import SongList from "@/Components/SongList.vue";
import FloatingActionButton from "@/Components/FloatingActionButton.vue";

const props = defineProps<{
    songs: {
        id: number,
        song_name: string,
        arranger: string,
        author: string,
        genre: string
    }[]
}>();
</script>

