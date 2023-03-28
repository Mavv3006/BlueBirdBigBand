<template>
    <ul class="text-white mt-3 gap-9 justify-center content-center">
        <li>
            <Link href="/">Home</Link>
        </li>
        <li class="nav-container">
            <span>Aktuelles</span>
            <ul class="dropdown-content min-w-[112px]">
                <li>
                    <Link href="/auftritte">Auftritte</Link>
                </li>
                <li>
                    <Link href="/presse">Presseinfos</Link>
                </li>
                <li>
                    <Link href="/buchung">Buchungsinsfos</Link>
                </li>
            </ul>
        </li>
        <li class="nav-container">
            <span>Band</span>
            <ul class="dropdown-content min-w-[112px]">
                <li>
                    <Link href="/about-us">Über uns</Link>
                </li>
                <li>
                    <Link href="/musiker">Musiker</Link>
                </li>
                <li>
                    <Link href="/anfahrt">Anfahrt</Link>
                </li>
            </ul>
        </li>
        <li class="nav-container">
            <span>Kontakt</span>
            <ul class="dropdown-content min-w-[112px]">
                <li>
                    <Link href="/kontakt">Kontakt</Link>
                </li>
                <li>
                    <Link href="/impressum">Impressum</Link>
                </li>
            </ul>
        </li>
        <li v-if="isLoggedIn" class="nav-container">
            <span>Intern</span>
            <ul class="dropdown-content min-w-[112px]">
                <li>
                    <Link href="/intern/emails">E-Mail Verteiler</Link>
                </li>
            </ul>
        </li>
        <li>
            <Link method="POST" as="button" v-if="isLoggedIn" :href="route('logout')">Logout</Link>
            <Link v-if="!isLoggedIn" href="login">Login</Link>
        </li>
    </ul>
</template>

<script lang="ts" setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed} from "vue";

const isLoggedIn = computed<boolean>(() => usePage().props.auth.user !== null);
</script>

<style scoped>
.nav-container {
    @apply pr-7 relative inline-block;
}

.dropdown-content {
    @apply hidden absolute bg-red-600 py-2 z-10 shadow-md -ml-4 rounded-md;
}

.nav-container:hover .dropdown-content {
    @apply block;
}

.nav-container:after {
    content: "";
    position: absolute;
    display: block;
    top: 50%;
    right: 13px;
    width: 0;
    height: 0;
    border-top: 4px solid #d61000;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    transition: border-bottom 0.1s, border-top 0.1s 0.1s;
}

ul > li {
    @apply relative px-4 leading-[3em] cursor-pointer font-semibold tracking-[1px] rounded-md whitespace-nowrap;
}

ul > li:hover {
    background-color: rgba(255, 255, 255, 0.2);
}
</style>
