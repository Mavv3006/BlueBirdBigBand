<template>
  <div class="bg-gray-800 relative hero h-72 md:h-96 lg:h-[30rem] xl:h-[40rem] 2xl:h-[48rem]">
    <div class="absolute h-full w-full bg-[#1b1b1b] opacity-70 top-0"></div>
    <div class="absolute w-full h-full">
      <div class="flex flex-col gap-8 items-center h-full justify-center ">
        <div class="text-white text-2xl w-3/4 text-center font-semibold">
          Herzlich Willkommen bei der Blue Bird Big Band
        </div>
        <div>
          <CallToActionButton as="anchor" name="Kontakt" href="/v2/kontakt"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">

import CallToActionButton from "@/Components/v2/CallToActionButton.vue";
</script>

<style scoped>
.hero {
  background-image: url('/assets/grouppictures/2023-05-07_v2.jpg');
  @apply bg-top bg-no-repeat bg-cover;
}
</style>
