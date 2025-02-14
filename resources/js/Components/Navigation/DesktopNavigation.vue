<template>
    <ul class="text-white mt-3 gap-9 justify-center content-center">
        <NavigationElement v-for="route in otherRoutes" :element="route"/>
        <NavigationElement v-if="!isLoggedIn" :element="loginRoute"/>
        <LogoutNavigationElement v-if="isLoggedIn" :element="logoutRoute" @logout="() => useLogout(logoutRoute)"/>
    </ul>
</template>

<script lang="ts" setup>
import {usePage} from '@inertiajs/vue3';
import {TopLevelRoute, useRoutes} from "@/Composables/useRoutes";
import NavigationElement from "@/Components/Navigation/NavigationElement.vue";
import LogoutNavigationElement from "@/Components/Navigation/LogoutNavigationElement.vue";
import {useLogout} from "@/Composables/useLogout";

const routes = useRoutes(
    usePage().props.auth.can,
    usePage().props.feature_flags
);
const isLoggedIn = usePage().props.auth.user !== null;
const loginRoute = routes.find(route => route.linkName === 'Login') as TopLevelRoute;
const logoutRoute = routes.find(route => route.linkName === 'Logout') as TopLevelRoute;
const otherRoutes = routes.filter(route => route.linkName !== 'Login' && route.linkName !== 'Logout');
</script>

<style scoped>
@reference "tailwindcss";
ul > li {
    @apply relative px-4 leading-[3em] cursor-pointer font-semibold tracking-[1px] rounded-md whitespace-nowrap;
}

ul > li:hover {
    background-color: rgba(255, 255, 255, 0.2);
}
</style>
