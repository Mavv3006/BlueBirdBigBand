<template>
    <div>
        <table>
            <thead>
            <tr>
                <td>Titel</td>
                <td>Arrangeur</td>
                <td>Autor</td>
                <td>Genre</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="song in songs">
                <td>{{ song.song_name }}</td>
                <td>{{ song.arranger }}</td>
                <td>{{ song.author }}</td>
                <td>{{ song.genre }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
const props = defineProps<{
    songs: {
        song_name: string,
        arranger: string,
        author: string,
        genre: string
    }[]
}>();
console.debug('props songs', props.songs)
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
