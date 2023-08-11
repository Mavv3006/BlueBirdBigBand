<template>
    <h1 class="pt-2 text-[#3d4449] font-bold border-t border-gray-300 text-center mb-2 text-2xl md:text-3xl lg:text-4xl">
        {{ instrument }}</h1>

    <div class="flex flex-col justify-evenly mb-2 gap-8 md:flex-row md:flex-wrap">
        <div v-for="musician in musicians" class="block text-center md:w-[30%] lg:w-fit lg:px-4">
            <img :src="musician.picture" :alt="musician.name" class="inline-block"/>
            <p class="text-center">{{ musician.name }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
import {defineProps} from 'vue';
import {Musician} from "@/types/musician";

const props = defineProps<{
    instrument: string,
    musicians: Musician[]
}>()
</script>

<style scoped>
img {
    @apply h-36;
    max-width: 100%;
}
</style>
