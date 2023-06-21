<template>
    <public-layout>
        <Head><title>Sitzposition bearbeiten</title></Head>
        <Heading>
            Sitzposition bearbeiten
        </Heading>

        <div v-for="data in seatingPosition" class="mb-8">
            <div class="text-bold text-xl mb-4">{{ data.instrument.name }}</div>

            <ul class="gap-4 flex flex-col">
                <li v-for="musician in data.musicians"
                    class="flex justify-between border rounded-md border-slate-400 py-2 px-4 mx-2 hover:shadow-md hover:border-slate-700">
                    <div>{{ musician.firstname }} {{ musician.lastname }}</div>
                    <div class="flex gap-6">
                        <div v-if="!isFirstMusician(musician)"
                             @click="moveUp(musician)"
                             class="hover:cursor-pointer">
                            <font-awesome-icon class="mr-1" icon="fa-solid fa-chevron-up"/>
                            <span class="hidden sm:inline md:hidden">vor</span>
                            <span class="hidden md:inline">Nach vorne</span>
                        </div>
                        <div v-if="!isLastMusician(musician)"
                             @click="moveDown(musician)"
                             class="hover:cursor-pointer">
                            <font-awesome-icon class="mr-1" icon="fa-solid fa-chevron-down"/>
                            <span class="hidden sm:inline md:hidden">zurück</span>
                            <span class="hidden md:inline">Nach hinten</span>
                        </div>
                    </div>
                </li>
            </ul>
            <p v-if="data.musicians.length === 0" class="text-sm ml-6">
                Keine Musiker vorhanden.
            </p>
        </div>

        <div class="flex justify-center">
            <PrimaryButton @click="save()">Speichern</PrimaryButton>
        </div>
    </public-layout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head, router} from '@inertiajs/vue3';
import {MusicianBackendDto, MusicianProp} from "@/types/musician";
import {ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps<{ data: MusicianProp[] }>();
const seatingPosition = ref(props.data);

const moveUp = (musicianToMove: MusicianBackendDto) => {
    moveMusician(musicianToMove, MovingDirection.UP);
};

const moveDown = (musicianToMove: MusicianBackendDto) => {
    moveMusician(musicianToMove, MovingDirection.DOWN);
};

const getMusicianArray = (musicianToMove: MusicianBackendDto) => seatingPosition
    .value
    .filter((value) => value.instrument.id === musicianToMove.instrument_id)[0]
    .musicians;

function moveMusician(musicianToMove: MusicianBackendDto, direction: MovingDirection) {
    let musicianArray = getMusicianArray(musicianToMove);
    let indexOfMusicianToMove = musicianArray.indexOf(musicianToMove);
    let musicianToReplace;
    switch (direction) {
        case MovingDirection.UP:
            musicianToReplace = musicianArray[indexOfMusicianToMove - 1];
            break;
        case MovingDirection.DOWN:
            musicianToReplace = musicianArray[indexOfMusicianToMove + 1];
            break;
    }
    let indexOfMusicianToReplace = musicianArray.indexOf(musicianToReplace);
    swap(musicianArray, indexOfMusicianToMove, indexOfMusicianToReplace);
}

const swap = (array: object[], index1: number, index2: number) => {
    array[index1] = array.splice(index2, 1, array[index1])[0];
}

enum MovingDirection {
    UP = 1,
    DOWN = 2,
}

const isFirstMusician = (musician: MusicianBackendDto): boolean => {
    let musicianArray = getMusicianArray(musician);
    let index = musicianArray.indexOf(musician);
    return index === 0;
}

const isLastMusician = (musician: MusicianBackendDto): boolean => {
    let musicianArray = getMusicianArray(musician);
    let index = musicianArray.indexOf(musician);
    return index === musicianArray.length - 1;
}

const save = () => {
    let data = seatingPosition
        .value
        .map((value) => {
            let musicians = value.musicians.map((value) => {
                return {id: value.id};
            });
            let instrument_id = value.instrument.id;
            return {musicians: musicians, instrument_id: instrument_id};
        });
    router.visit(
        '/admin/musicians/seating-position',
        {
            data: {data: data},
            method: 'put',
            onStart: console.debug,
        }
    );
}
</script>

<style scoped>

</style>
