<template>
  <div class="bg-white">
    <div class="container mx-auto">
      <SectionHeader class="pl-16 pt-8 pb-4">Unsere nächsten Auftritte</SectionHeader>

      <div
          class="flex flex-col items-center gap-8 pb-16 md:flex-row md:flex-wrap md:justify-center lg:mx-8 lg:gap-x-16 xl:justify-evenly">
        <Concert v-for="concert in concerts" :data="concert"/>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {Concert as ConcertType} from "@/types/concert";
import Concert from "@/Components/v2/Concert/Concert.vue";
import SectionHeader from "@/Components/v2/SectionHeader.vue";

defineProps<{
  concerts: ConcertType[]
}>();
</script>

<style scoped>

</style>
