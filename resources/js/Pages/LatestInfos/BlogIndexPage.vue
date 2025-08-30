<template>
<public-layout page-title="Blog">

    <div v-html="content"></div>

</public-layout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";

defineProps<{
    content:string
}>();
</script>

<style scoped>

</style>
