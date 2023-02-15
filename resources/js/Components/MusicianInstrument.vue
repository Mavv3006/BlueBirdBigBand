<template>
    <h1 class="pt-2 border-t border-gray-300 text-center mb-2 text-2xl md:text-3xl lg:text-4xl">{{ instrument }}</h1>

    <div class="flex flex-col justify-evenly mb-2 gap-8 md:flex-row md:flex-wrap">
        <div v-for="musician in musicians" class="block text-center max-w-[108px] sm:w-[45%] md:w-[30%] lg:px-4">
            <img :src="musician.picture" :alt="musician.name"/>
            <p class="text-center">{{ musician.name }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
export type Instrument = "Bandleader" | "Gesang" | "Saxophone" | "Posaunen" | "Trompeten" | "Rhythmusgruppe";
export type Musician = { picture: String, name: String };

import {defineProps} from 'vue';

const props = defineProps<{
    instrument: Instrument,
    musicians: Musician[]
}>()
</script>

<style scoped>
img {
    @apply h-36;
    aspect-ratio: 0.75;
    max-width: 100%;
}
</style>
