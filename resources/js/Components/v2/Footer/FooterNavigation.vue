<template>
  <div>
    <FooterHeading>Navigation</FooterHeading>

    <div class="flex flex-col gap-2 mt-2">
      <FooterLink v-for="link in navLinks" :href="link.link">{{ link.name }}</FooterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import FooterHeading from "@/Components/v2/Footer/FooterHeading.vue";
import FooterLink from "@/Components/v2/Footer/FooterLink.vue";
import {useNavigationLinks} from "@/Composables/useNavigationLinks";

const navLinks = useNavigationLinks();
</script>

<style scoped>

</style>
