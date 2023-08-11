<template>
  <a :href="href" class="text-sm text-[#575757]">
    <slot/>
  </a>
</template>

<script setup lang="ts">
defineProps<{ href: string }>();
</script>

<style scoped>

</style>
