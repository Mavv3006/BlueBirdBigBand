<template>
    <PublicLayout>
        <Heading>Musiker Management</Heading>

        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Instrument</th>
                <th>Stimme</th>
                <th>Aktiv</th>
                <th>Aktion</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="musician in data">
                <td>{{ musician.id }}</td>
                <td>{{ musician.firstname }}</td>
                <td>{{ musician.lastname }}</td>
                <td>{{ musician.instrument.name }}</td>
                <td>{{ musician.part ?? 'n/a' }}</td>
                <td>{{ musician.isActive ? 'Ja' : 'Nein' }}</td>
                <td class="flex flex-wrap">
                    <Link :href="`musicians/${musician.id}`" class="mr-1">Anschauen</Link>
                    <Link :href="`musicians/${musician.id}/edit`" class="mr-1">Bearbeiten</Link>
                    <Link as=button :href="`musicians/${musician.id}`" method="delete" class="text-red-600">Löschen
                    </Link>
                </td>
            </tr>
            </tbody>
        </table>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import {Link} from "@inertiajs/vue3";
import Heading from "@/Components/Heading.vue";

const props = defineProps<{
    data: {
        id: number,
        firstname: string,
        lastname: string,
        picture_filepath?: string,
        isActive: boolean,
        part?: number,
        instrument_id: number,
        instrument: {
            name: string,
            default_picture_filepath: string
        }
    }[],
}>();
console.debug(props.data);
</script>

<style scoped>
table {
    border-collapse: collapse;
    @apply w-full;
}

td, th {
    border: 1px solid #ddd;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

th {
    background-color: #04AA6D;
    @apply text-white py-2 text-left;
}
</style>
