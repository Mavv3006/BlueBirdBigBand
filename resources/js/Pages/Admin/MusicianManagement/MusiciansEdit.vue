<template>
    <PublicLayout>
        <Heading>Musiker bearbeiten</Heading>
        <Head><title>Musiker bearbeiten</title></Head>

        <MusicianFormular
            :instruments="instruments"
            :musician="musician"
            :submit_url="`/admin/musicians/${props.musician.id}`"
            method="put"
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

</script>
