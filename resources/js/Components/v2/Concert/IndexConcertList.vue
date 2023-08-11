<template>
  <div class="bg-white">
    <SectionHeader class="pl-16 pt-8">Unsere nächsten Auftritte</SectionHeader>

    <div class="flex justify-evenly mt-5 pb-20">
      <Concert v-for="concert in concerts" :data="concert"/>
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
