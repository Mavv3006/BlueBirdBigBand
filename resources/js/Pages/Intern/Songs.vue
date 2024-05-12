<template>
    <PublicLayout>
        <Heading>Songs</Heading>

        <SongList :songs="songs"/>
    </PublicLayout>
</template>

<script setup lang="ts">
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

