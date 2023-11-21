<template>
    <div class="sm:flex sm:flex-row sm:justify-evenly">
        <div class="min-w-full sm:min-w-0 sm:w-2/5 md:w-1/3">
            <img
                :src="instrument.default_picture_filepath"
                :alt="`Bild von Instrument ${instrument.name}`">
        </div>

        <div class="min-w-full sm:min-w-0 sm:w-80 border border-gray-400">
            <h1 class="p-2 text-[#3d4449] font-bold mb-2 text-xl md:text-2xl lg:text-3xl">
                {{ instrument.name }}
            </h1>

            <div class="flex flex-col mb-2 gap-1 md:flex-wrap">
                <div v-for="musician in musicians" class="block pl-6">
                    {{ musician.name }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {Musician, ReducedInstrument} from "@/types/musician";

defineProps<{
    instrument: ReducedInstrument,
    musicians: Musician[]
}>()
</script>
