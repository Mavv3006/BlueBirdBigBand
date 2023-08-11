<template>
  <PublicLayout page-title="Willkommen">
    <IndexConcertList :concerts="upcomingConcerts"/>
  </PublicLayout>
</template>

<script lang="ts" setup>
import IndexConcertList from "@/Components/v2/Concert/IndexConcertList.vue";
import {Concert} from "@/types/concert";
import PublicLayout from "@/Layouts/v2/PublicLayout.vue";

defineProps<{
  upcomingConcerts: Concert[]
}>();
</script>
