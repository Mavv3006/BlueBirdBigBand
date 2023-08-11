<template>
  <div class="bg-[#eaeaea] w-full sticky">
    <div class=" pt-8 pb-8 flex gap-8 flex-col
      md:px-12 md:flex-row md:justify-between
      lg:px-16 xl:px-28 2xl:container 2xl:mx-auto">
      <div class="flex justify-center md:grow lg:grow-0">
        <div class="flex gap-8 items-center w-fit md:flex-col lg:flex-row">
          <img class="h-[120px]" src="/assets/logos/intrologo.gif" alt="Band Logo">
          <p class="flex  text-[#575757] text-sm w-64 md:w-fit lg:w-80">
            Wir sind die Blue Bird Big Band der Städtischen Musikschule Speyer. Aktuell suchen wir noch Musiker/innen
            für
            die Instrumente Schlagzeug, Posaune und Klavier.
          </p>
        </div>
      </div>

      <div class="flex justify-center">
        <div class="flex gap-16 md:gap-12 lg:gap-16">
          <FooterNavigation/>
          <FooterContact class="w-60"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import FooterNavigation from "@/Components/v2/Footer/FooterNavigation.vue";
import FooterContact from "@/Components/v2/Footer/FooterContact.vue";
</script>

<style scoped>

</style>
