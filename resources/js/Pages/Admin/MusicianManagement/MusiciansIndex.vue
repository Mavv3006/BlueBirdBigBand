<template>
    <PublicLayout>
        <Heading>Musiker Management</Heading>
        <Head><title>Musiker Management</title></Head>

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
                <td>
                    <Link :href="`musicians/${musician.id}`" class="text-blue-600 mr-1 hover:underline">
                        {{ musician.firstname }}
                    </Link>
                </td>
                <td>{{ musician.lastname }}</td>
                <td>{{ musician.instrument.name }}</td>
                <td>{{ musician.part ?? 'n/a' }}</td>
                <td>{{ musician.isActive ? 'Ja' : 'Nein' }}</td>
                <td class="flex flex-wrap gap-4">
                    <Link :href="`musicians/${musician.id}/edit`" class="mr-1">
                        <font-awesome-icon icon="fa-solid fa-pen"/>
                    </Link>
                    <Link :href="`musicians/${musician.id}`" as=button class="text-red-600" method="delete">
                        <font-awesome-icon icon="fa-solid fa-trash"/>
                    </Link>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="flex justify-end mt-4">
            <Link href="musicians/create"
                  class="border border-slate-700 shadow-md hover:shadow-xl rounded-full w-12 h-12 flex justify-center items-center hover:bg-gray-200 active:bg-gray-300">
                <font-awesome-icon :icon="['fas', 'plus']"/>
            </Link>
        </div>
    </PublicLayout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import {Link, Head} from "@inertiajs/vue3";
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
