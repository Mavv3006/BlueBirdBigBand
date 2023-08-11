<template>
  <div class="wrapper">
    <div class="content">
      <Header/>
      <IndexConcertList :concerts="upcomingConcerts"/>
    </div>

    <div class="footer">
      <Footer/>
    </div>
  </div>
</template>

<script lang="ts" setup>
import Header from '@/Components/v2/Navigation/Header.vue';
import Footer from '@/Components/v2/Footer/Footer.vue';
import IndexConcertList from "@/Components/v2/Concert/IndexConcertList.vue";
import {Concert} from "@/types/concert";

defineProps<{
  upcomingConcerts: Concert[]
}>();
</script>

<style scoped>
.wrapper {
  @apply flex flex-col h-screen;
}

.content {
  flex: 1 0 auto;
}

.footer {
  flex-shrink: 0;
}
</style>
