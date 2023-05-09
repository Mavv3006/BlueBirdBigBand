<template>
    <PublicLayout>
        <Heading>Neuen Musiker anlegen</Heading>

        <MusicianFormular
            :instruments="instruments"
            method="post"
            submit_url="/admin/musicians"/>
    </PublicLayout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import MusicianFormular from "@/Components/MusicianFormular.vue";
import {defineProps} from 'vue';

const props = defineProps<{ instruments: { name: string, id: number }[] }>();
</script>

<style scoped>

</style>
