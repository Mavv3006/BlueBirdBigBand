<template>
    <li v-if="element.link && !element.submenu">
        <button v-if="element.link" @click="$emit('logout')">{{ element.linkName }}</button>
    </li>
    <li v-if="!element.link && element.submenu"
        class="nav-container">
        <span>{{ element.linkName }}</span>
        <ul class="dropdown-content hidden absolute bg-red-600 py-2 z-10 shadow-md -ml-4 rounded-md min-w-[112px]">
            <li v-for="submenu in element.submenu">
                <Link :href="submenu.link">{{ submenu.linkName }}</Link>
            </li>
        </ul>
    </li>
</template>

<script lang="ts" setup>
import {defineProps} from 'vue';
import {Route} from "@/Composables/useRoutes";
import {Link} from '@inertiajs/vue3';

const props = defineProps<{ element: Route }>();

if (props.element.link !== undefined && props.element.submenu !== undefined) {
    throw TypeError('both link and submenu are not supported');
}
</script>

<style scoped>
@reference "tailwindcss";
li {
    @apply relative px-4 leading-[3em] cursor-pointer font-semibold tracking-[1px] rounded-md whitespace-nowrap;
}

li:hover {
    background-color: rgba(255, 255, 255, 0.2);
}

.nav-container {
    @apply pr-7 relative inline-block;
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
</style>
