<template>
  <PublicLayout page-title="Willkommen">
    <div class="flex flex-col">
      <HeroSection/>
    <IndexConcertList :concerts="upcomingConcerts"/>
    </div>
  </PublicLayout>
</template>

<script lang="ts" setup>
import IndexConcertList from "@/Components/v2/Concert/IndexConcertList.vue";
import {Concert} from "@/types/concert";
import PublicLayout from "@/Layouts/v2/PublicLayout.vue";
import HeroSection from "@/Components/v2/HeroSection.vue";

defineProps<{
  upcomingConcerts: Concert[]
}>();
</script>
