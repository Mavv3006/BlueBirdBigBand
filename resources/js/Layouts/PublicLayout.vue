<template>
    <Head>
        <link href="favicon.png" rel="icon">
    </Head>

    <header class="md:flex md:relative md:flex-col md:justify-center">
        <div class="bg-[#d61000] h-12 mt-2 md:h-[calc(10.125vw-29.5px)] md:min-h-12 max-h-24">
            <div class="h-full md:w-full">
                <Link class="flex justify-center items-center h-full p-0" href="/">
                    <img alt="Logo der Blue Bird Big Band" class="max-h-12 pr-11 md:pr-0 md:h-full"
                         src="assets/logos/logo-header.gif">
                </Link>
            </div>
        </div>

        <DesktopNavigation class="hidden md:flex md:w-full"/>
        <MobileNavigation class="md:hidden"/>
    </header>

    <main
        class="w-[85vw] mt-3 mb-3 mx-auto bg-white rounded-2xl p-4 pt-6 transition-all duration-300 md:pt-8 md:w-[88vw] lg:w-[85vw] xl:w-[80vw] 2xl:w-[75vw]">
        <slot/>
    </main>
</template>

<script setup>
import {Head} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';
import DesktopNavigation from "@/Components/Navigation/DesktopNavigation.vue";
import MobileNavigation from "@/Components/Navigation/MobileNavigation.vue";
</script>

<style>
body {
    background-color: #041286;
}
</style>

<style scoped>
@media (min-width: 768px ) {
    img {
        max-height: unset;
    }
}
</style>
