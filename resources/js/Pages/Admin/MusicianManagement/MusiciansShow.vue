<template>
    <PublicLayout>
        <Heading>Musiker anzeigen</Heading>

        <div class="flex flex-col sm:flex-row gap-8">
            <div class="mx-auto">
                <img
                    :alt="`Bild von ${musician.firstname} ${musician.lastname}`"
                    :src="picturePath"
                    class="max-h-36"
                >
            </div>
            <div class="flex grow flex-col gap-2">
                <div class="flex flex-col gap-2">
                    <p> Name: {{ musician.firstname }} {{ musician.lastname }} </p>
                    <p>Instrument: {{ instrument.name }}</p>
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
                        class="text-red-600 border-red-600 border rounded-md hover:bg-gray-100 active:bg-gray-200 px-2 py-1"
                        method="delete"
                    >
                        Löschen
                    </Link>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Link} from '@inertiajs/vue3';
import {computed} from "vue";

const props = defineProps<{
    musician: {
        id: number,
        firstname: string,
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

const picturePath = computed<string>(() => {
    if (props.musician.picture_filepath === undefined || props.musician.picture_filepath === null) {
        return `/${props.instrument.default_picture_filepath}`;
    }
    return `/storage/${props.musician.picture_filepath}`;
});
</script>

<style scoped>

</style>
