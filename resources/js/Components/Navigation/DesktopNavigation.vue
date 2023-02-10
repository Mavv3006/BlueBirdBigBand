<template>
    <ul class="text-white mt-3 gap-9 justify-center content-center">
        <li>
            <Link href="/">Home</Link>
        </li>
        <li class="nav-container">
            <span>Aktuelles</span>
            <ul class="dropdown-content min-w-[112px]">
                <li>Auftritte</li>
                <li>
                    <Link href="presse">Presseinfos</Link>
                </li>
                <li>
                    <Link href="buchung">Buchungsinsfos</Link>
                </li>
            </ul>
        </li>
        <li class="nav-container">
            <span>Band</span>
            <ul class="dropdown-content min-w-[112px]">
                <li>
                    <Link href="about-us">Über uns</Link>
                </li>
                <li>
                    <Link href="musiker">Musiker</Link>
                </li>
                <li>
                    <Link href="anfahrt">Anfahrt</Link>
                </li>
            </ul>
        </li>
        <li class="nav-container">
            <span>Kontakt</span>
            <ul class="dropdown-content min-w-[112px]">
                <li>
                    <Link href="kontakt">Kontakt</Link>
                </li>
                <li>
                    <Link href="impressum">Impressum</Link>
                </li>
            </ul>
        </li>
        <li>Login</li>
    </ul>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';</script>

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
    @apply relative px-4 leading-[3em] cursor-pointer font-semibold tracking-[1px] rounded-md;
}

ul > li:hover {
    background-color: rgba(255, 255, 255, 0.2);
}
</style>
