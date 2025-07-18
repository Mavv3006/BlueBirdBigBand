<template>
    <header class="md:flex md:relative md:flex-col md:justify-center">
        <div class="relative bg-[#d61000] h-12 mt-2 md:h-[calc(10.125vw-29.5px)] md:min-h-12 max-h-24">
            <div class="h-full md:w-full">
                <Link class="flex justify-center items-center h-full p-0" href="/">
                    <img :src="logoURL"
                         alt="Logo der Blue Bird Big Band"
                         class="max-h-12 pr-11 md:pr-0 md:h-full"
                    >
                </Link>
            </div>

            <button
                :class="{'open-mobile-toggle':mobileNavIsOpen}"
                class="h-[48px] w-[60px] absolute top-0 right-0 text-white md:hidden"
                @click="toggleMobileMenu()"
            >
                <font-awesome-icon
                    v-if="mobileNavIsOpen"
                    class="text-2xl translate-y-[2px]"
                    icon="fa-solid fa-close"
                />
                <font-awesome-icon
                    v-if="!mobileNavIsOpen"
                    class="text-xl"
                    icon="fa-solid fa-bars"
                />
            </button>
        </div>

        <DesktopNavigation class="hidden md:flex md:w-full"/>
        <div class="relative">
            <MobileNavigation
                v-model:is-open="mobileNavIsOpen"
                :class="{'opacity-100': mobileNavIsOpen, 'z-0': mobileNavIsOpen, 'z-[-1]': !mobileNavIsOpen}"
                class="absolute w-full opacity-0 md:hidden"
            />
        </div>
    </header>

    <main
        class="w-[85vw] mt-3 mx-auto bg-white rounded-t-2xl p-4 pt-6 transition-all duration-300 md:pt-8 md:w-[88vw] lg:w-[85vw] xl:w-[80vw] 2xl:w-[75vw]">
        <slot/>
    </main>

        <Footer
            class="w-[85vw] mb-3 mx-auto bg-[#f0f0f0] rounded-b-2xl transition-all duration-300 md:pt-8 md:w-[88vw] lg:w-[85vw] xl:w-[80vw] 2xl:w-[75vw]"/>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import {computed, ref} from 'vue';
import DesktopNavigation from "@/Components/Navigation/DesktopNavigation.vue";
import MobileNavigation from "@/Components/Navigation/MobileNavigation.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import Footer from "@/Components/Footer.vue"

const mobileNavIsOpen = ref<boolean>(false);

const logoURL = computed<string>(() => `${window.location.protocol}//${window.location.host}/assets/logos/logo-header.gif`);

const toggleMobileMenu = () => {
    mobileNavIsOpen.value = !mobileNavIsOpen.value;
}
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

.open-mobile-toggle {
    background-color: #041286;
}
</style>
