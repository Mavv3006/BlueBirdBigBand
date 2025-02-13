<template>
    <div class="mb-6 border-b">
        <button v-on:click="toggle" class="flex justify-between w-full font-bold">
            {{ props.title }}
            <svg
                class="h-4 w-4 transition-transform duration-200"
                :class="{ 'rotate-180': isOpen }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{2}" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div class="pb-4" v-if="isOpen">
            <slot/>
        </div>
    </div>
</template>

<script setup lang="ts">
import {ref} from "vue";

let props = defineProps<{
    title: string,
}>()

let isOpen = ref(false);

const toggle = () => {
    isOpen.value = !isOpen.value;
}
</script>
