<template>
  <button>{{ name }}</button>
</template>

<script setup lang="ts">
defineProps<{
  name: string
}>();
</script>

<style scoped>
button {
  @apply text-white bg-primary rounded-xl px-[26px] py-[11px] drop-shadow-lg;
}
</style>