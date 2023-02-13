<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps(['href']);
</script>

<template>
    <Link
        :href="href"
        class="border-b-2 border-transparent text-blue-900 hover:border-blue-900 focus:outline-none focus:text-blue-900 focus:border-blue-900 transition duration-150 ease-in-out">
        <slot/>
    </Link>
</template>
