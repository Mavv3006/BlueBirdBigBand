<template>
    <Link :href="link"
          class="border border-slate-700 shadow-md hover:shadow-xl rounded-full w-12 h-12 flex justify-center items-center hover:bg-gray-200 active:bg-gray-300">
        <font-awesome-icon :icon="['fas', 'plus']"/>
    </Link>
</template>
<script setup lang="ts">
import {Link} from '@inertiajs/vue3';

const props = defineProps<{ link: string }>();
</script>
