<template>
    <img :alt="alt" :src="src"/>
</template>

<script lang="ts" setup>
import {defineProps} from 'vue';

const props = defineProps<{
    src: string,
    alt: string
}>();
</script>

<style scoped>
img {
    @apply h-36;
    max-width: 100%;
}
</style>
