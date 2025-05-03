<template>
    <Contact class="w-1/2" email="buchung@bluebirdbigband.de" name="Buchung" :bold_name="bold_name"/>
</template>

<script setup lang="ts">
import Contact from "@/Components/Contact.vue";
import {defineProps} from 'vue';

interface Props {
    bold_name?: boolean
}

const props = withDefaults(defineProps<Props>(), {bold_name: false})
</script>
