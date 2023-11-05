<template>
    <div class="flex flex-row justify-evenly">
        <div class="w-64 bg-amber-300 ">
            <img
                :src="instrument.tux_filepath"
                :alt="`Bild von Instrument ${instrument.name}`">
        </div>

        <div class="w-80 border border-gray-400">
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
