<template>
  <div class="flex flex-row justify-evenly">
    <div class="w-64 bg-amber-300 h-12">
      h
    </div>

    <div class="w-80 border border-gray-400">
      <h1 class="p-2 text-[#3d4449] font-bold mb-2 text-xl md:text-2xl lg:text-3xl">
        {{ instrument }}
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
