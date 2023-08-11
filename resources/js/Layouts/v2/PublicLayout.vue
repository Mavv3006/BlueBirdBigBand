<template>
  <div class="wrapper">

    <Head><title>{{ pageTitle }}</title></Head>

    <div class="content">
      <Header/>
      <slot/>
    </div>

    <div class="footer">
      <Footer/>
    </div>
  </div>
</template>

<script setup lang="ts">
import Footer from "@/Components/v2/Footer/Footer.vue";
import Header from "@/Components/v2/Navigation/Header.vue";
import {Head} from '@inertiajs/vue3';

defineProps<{ pageTitle: string }>();
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
