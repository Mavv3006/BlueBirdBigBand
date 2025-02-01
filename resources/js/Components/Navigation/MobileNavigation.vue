<template>
    <div class="relative font-semibold shadow-lg">
        <div class="absolute w-full">
            <ul class="flex flex-col content-center">
                <MobileNavbarElement v-for="(route) in otherRoutes" :element="route"/>
                <MobileLogoutNavbarElement v-if="isLoggedIn" :element="logoutRoute" @logout="logout"/>
                <MobileNavbarElement v-if="!isLoggedIn" :element="loginRoute"/>
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {router, usePage} from '@inertiajs/vue3';
import MobileNavbarElement from "@/Components/Navigation/MobileNavbarElement.vue";
import {TopLevelRoute, useRoutes} from "@/Composables/useRoutes";
import MobileLogoutNavbarElement from "@/Components/Navigation/MobileLogoutNavbarElement.vue";

const isLoggedIn = usePage().props.auth.user !== null;

const routes = useRoutes(
    usePage().props.auth.can,
    usePage().props.feature_flags
);
const loginRoute = routes.find(route => route.linkName === 'Login') as TopLevelRoute;
const logoutRoute = routes.find(route => route.linkName === 'Logout') as TopLevelRoute;
const otherRoutes = routes.filter(route => route.linkName !== 'Login' && route.linkName !== 'Logout');

const logout = () => {
    console.log('logout');
    router.visit(
        logoutRoute.link,
        {
            method: 'post',
        }
    )
};
</script>

<style scoped>
ul {
    list-style: none;
}
</style>
