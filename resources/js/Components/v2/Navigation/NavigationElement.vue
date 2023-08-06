<template>
  <div class="text-[#1b1b1b] font-semibold">
    {{ name }}
  </div>
</template>

<script lang="ts" setup>
defineProps<{ name: string }>();
</script>

<style scoped>

</style>