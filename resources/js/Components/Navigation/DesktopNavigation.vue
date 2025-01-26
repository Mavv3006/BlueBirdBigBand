<template>
    <ul class="text-white mt-3 gap-9 justify-center content-center">
        <NavigationElement v-for="route in routes" :element="route"/>
    </ul>
</template>

<script lang="ts" setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed} from "vue";
import {useRoutes} from "@/Composables/useRoutes";
import NavigationElement from "@/Components/Navigation/NavigationElement.vue";

const routes = useRoutes(
    usePage().props.auth.user !== null,
    usePage().props.auth.can,
    usePage().props.feature_flags);
</script>

<style scoped>
ul > li {
    @apply relative px-4 leading-[3em] cursor-pointer font-semibold tracking-[1px] rounded-md whitespace-nowrap;
}

ul > li:hover {
    background-color: rgba(255, 255, 255, 0.2);
}
</style>
