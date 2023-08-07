<template>
    <div class="header" :class="{'shadow-[0_0_12px_11px_white]':!isMobileMenuOpen}">
        <div class="lg:flex lg:justify-between lg:items-center h-full">
            <div class="title">
                <a href="/v2/">Blue Bird Big Band</a>
            </div>
            <div class="hidden mr-[60px] gap-12 relative items-center lg:flex">
                <NavigationElement v-for="element in linkNavElements" :name="element.name"/>
                <CallToActionButton v-for="element in ctaNavElements" :name="element.name"/>
            </div>
        </div>
        <font-awesome-icon
            @click="isMobileMenuOpen = !isMobileMenuOpen"
            class="absolute cursor-pointer top-[15px] h-[30px] right-[30px]
        lg:hidden"
            :icon="isMobileMenuOpen?'fa-solid fa-close':'fa-solid fa-bars'"/>
    </div>
    <div v-if="isMobileMenuOpen" class="mobile-menu">
        <div v-for="element in navElements">{{ element.name }}</div>
    </div>
</template>

<script lang="ts" setup>
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import NavigationElement from "@/Components/v2/Navigation/NavigationElement.vue";
import CallToActionButton from "@/Components/v2/CallToActionButton.vue";
import {ref} from "vue";

const isMobileMenuOpen = ref(false);

const navElements: { name: string, link?: string, type: "cta" | "link" }[] = [
    {name: "Home", type: "link"},
    {name: "Auftritte", type: "link"},
    {name: "Band", type: "link"},
    {name: "Kontakt", type: "link"},
    {name: "Login", type: "cta"},
];

const linkNavElements = navElements.filter((value) => value.type === "link");
const ctaNavElements = navElements.filter((value) => value.type === "cta");
</script>

<style scoped>
.header {
    @apply h-[60px] bg-white text-primary relative
    lg:h-[90px];
}

.title {
    @apply font-roboto font-bold text-[24px] text-center flex items-center justify-center h-full
    md:text-left md:ml-[60px] lg:text-[32px];
}

.mobile-menu {
    @apply bg-white text-primary shadow-[0_0_12px_11px_white] flex flex-col gap-2 pb-2;
}

.mobile-menu div {
    @apply bg-gray-100 py-2 pl-10 text-black font-bold rounded-lg cursor-pointer
    hover:bg-gray-200
    active:bg-gray-300;
}
</style>
