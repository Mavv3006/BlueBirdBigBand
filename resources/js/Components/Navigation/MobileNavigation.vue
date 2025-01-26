<template>
    <div class="relative font-semibold shadow-lg">
        <div class="absolute w-full">
            <ul class="flex flex-col content-center">
                <MobileNavbarElement v-for="(route) in routes" :element="route"/>
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {usePage} from '@inertiajs/vue3';
import MobileNavbarElement from "@/Components/Navigation/MobileNavbarElement.vue";
import {useRoutes} from "@/Composables/useRoutes";

const routes = useRoutes(
    usePage().props.auth.user !== null,
    usePage().props.auth.can,
    usePage().props.feature_flags);
</script>

<style scoped>
ul {
    list-style: none;
}

.submenu-element {
    @apply p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white;
}
</style>
