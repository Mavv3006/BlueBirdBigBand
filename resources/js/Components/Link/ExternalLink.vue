<script setup>
const props = defineProps(['href']);
</script>

<template>
    <a
        :href="href" target="_blank"
        class="border-b-2 border-transparent text-blue-900 hover:border-blue-900 focus:outline-hidden focus:text-blue-900 focus:border-blue-900 transition duration-150 ease-in-out">
        <slot/>
    </a>
</template>
