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
                <td
                    :class="{'play-song': song.file_path !== null}"
                    @click="songTitleClicked(song)"
                >
                    {{ song.title }}
                </td>
                <td>{{ song.arranger }}</td>
                <td>{{ song.author }}</td>
                <td>{{ song.genre }}</td>
                <td v-if="showActions">
                    <Link :href="`songs/${song.id}/edit`" class="mr-4">
                        <font-awesome-icon icon="fa-solid fa-pen"/>
                    </Link>
                    <Link :href="`songs/${song.id}`" as=button class="text-red-600" method="delete">
                        <font-awesome-icon icon="fa-solid fa-trash"/>
                    </Link>
                </td>
            </tr>
            </tbody>
        </table>

        <Modal :show="showModal" @close="closeModal">
            <div class="p-4">
                <h1>{{ selectedSong.title }}</h1>
                <audio :src="downloadUrl" class="mt-4" controls></audio>
                <PrimaryButton class="mt-4" @click="closeModal">Schließen</PrimaryButton>
            </div>
        </Modal>
    </div>
</template>

<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import {computed, ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

type Song = {
    id: number,
    title: string,
    arranger: string,
    author: string,
    genre: string,
    file_path?: string,
};

const showModal = ref<boolean>(false);
const selectedSong = ref<Song | null>(null);

const downloadUrl = computed<string>(() => {
    console.debug(selectedSong.value.file_path ?? 'no file path');
    let url = `/api/download/song/${selectedSong.value.id}`;
    console.debug(`trying to download song ${selectedSong.value.title} from '${url}'`)
    return url;
});

const props = defineProps<{
    songs: Song[],
    showActions?: boolean,
    showId?: boolean,
}>();

const songTitleClicked = (song: Song) => {
    if (song.file_path === null) return;

    selectedSong.value = song;
    openModal();
}

const openModal = () => showModal.value = true;
const closeModal = () => showModal.value = false;


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

.play-song {
    @apply text-blue-600 mr-1 hover:cursor-pointer;
}
</style>
