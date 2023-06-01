<template>
    <PublicLayout>
        <Heading>Musiker bearbeiten</Heading>
        <Head><title>Musiker bearbeiten</title></Head>

        <MusicianFormular
            :instruments="instruments"
            :submit_url="`/admin/musicians/${musician.id}`"
            method="put"
            :musician="musician"
        />
    </PublicLayout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from "@inertiajs/vue3";
import MusicianFormular from "@/Components/MusicianFormular.vue";

const props = defineProps<{
    musician: {
        id: number,
        firstname: string,
        lastname: string,
        picture_filepath?: string,
        isActive: boolean,
        instrument_id: number
    },
    instruments: { name: string, id: number }[]
}>();

console.debug({'musician': props.musician, 'instruments': props.instruments});
</script>
