<template>
    <PublicLayout>
        <Heading>Musiker anzeigen</Heading>

        <div class="flex gap-8">
            <img :src="picture" :alt="`Bild von ${musician.firstname} ${musician.lastname}`">
            <div class="flex flex-col gap-2">
                <div class="flex flex-col gap-2">
                    <p> Name: {{ musician.firstname }} {{ musician.lastname }} </p>
                    <p>Instrument: {{ instrument.name }}</p>
                    <p>Stimme: {{ musician.part ?? 'n/a' }}</p>
                    <p>Aktiv: {{ musician.isActive ? 'Ja' : 'Nein' }}</p>
                </div>
                <div class="flex gap-4">
                    <Link
                        :href="`${musician.id}/edit`"
                        class="border border-slate-700 rounded-md hover:bg-gray-100 active:bg-gray-200 px-2 py-1"
                    >
                        Bearbeiten
                    </Link>
                    <Link
                        method="delete"
                        class="text-red-600 border-red-600 border rounded-md hover:bg-gray-100 active:bg-gray-200 px-2 py-1"
                    >
                        Löschen
                    </Link>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {computed} from "vue";
import {Link} from '@inertiajs/vue3';

const props = defineProps<{
    musician: {
        id: number,
        firstname: string,
        part?: number,
        lastname: string,
        picture_filepath?: string,
        isActive: boolean,
        instrument_id: number
    },
    instrument: {
        name: string,
        default_picture_filepath: string
    }
}>();

const picture = computed<string>(() => {
    return '/' + (props.musician.picture_filepath ?? props.instrument.default_picture_filepath);
});
</script>

<style scoped>

</style>
