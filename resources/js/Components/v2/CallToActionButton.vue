<template>
    <a v-if="as === 'anchor'" :href="href">{{ name }}</a>
    <button v-if="as === 'button'" @click="$emit('click')">{{ name }}</button>
</template>

<script setup lang="ts">
defineEmits(['click']);

defineProps<{
    name: string,
    as: 'anchor' | 'button',
    href?: string
}>();
</script>

<style scoped>
button, a {
    @apply text-white bg-primary rounded-xl px-[26px] py-[11px] drop-shadow-lg;
}
</style>
