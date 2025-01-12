<template>
    <header class="md:flex md:relative md:flex-col md:justify-center">
        <div class="relative bg-[#d61000] h-12 mt-2 md:h-12">
            <div class="h-full md:w-full">
                <Link class="flex justify-center items-center h-full p-0" href="/">
                    <img src="/assets/logos/logo-header.gif"
                         alt="Logo der Blue Bird Big Band"
                         class="max-h-12 pr-11 md:pr-0 md:h-full"
                    >
                </Link>
            </div>


        </div>
    </header>

    <main
        class="w-[85vw] mt-3 mb-3 mx-auto bg-white rounded-2xl p-4 pt-6 transition-all duration-300 md:pt-8 md:w-[88vw] lg:w-[85vw] xl:w-[80vw] 2xl:w-[75vw]">
        <slot/>
    </main>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
</script>

<style>
body {
    background-color: #041286;
}
</style>
