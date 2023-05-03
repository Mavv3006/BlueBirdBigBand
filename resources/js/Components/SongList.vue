<template>
    <div>
        <table>
            <thead>
            <tr>
                <th v-if="showId">#</th>
                <th>Titel</th>
                <th>Arrangeur</th>
                <th>Autor</th>
                <th>Genre</th>
                <th v-if="showActions">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="song in songs">
                <td v-if="showId">{{ song.id }}</td>
                <td>{{ song.title }}</td>
                <td>{{ song.arranger }}</td>
                <td>{{ song.author }}</td>
                <td>{{ song.genre }}</td>
                <td v-if="showActions">
                    <Link :href="`songs/${song.id}`" as=button class="text-red-600" method="delete">
                        <font-awesome-icon icon="fa-solid fa-trash"/>
                    </Link>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/vue3";

const props = defineProps<{
    songs: {
        id: number,
        title: string,
        arranger: string,
        author: string,
        genre: string
    }[],
    showActions?: boolean,
    showId?: boolean,
}>();
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
