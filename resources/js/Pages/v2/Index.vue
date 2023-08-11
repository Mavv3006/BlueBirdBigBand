<template>
  <div class="bg-gray-800 h-screen">
    <Header/>

    <!--    <div class="w-full h-28 bg-gray-500"></div>-->

    <IndexConcertList :concerts="upcomingConcerts"/>

    <Footer/>
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

</style>
