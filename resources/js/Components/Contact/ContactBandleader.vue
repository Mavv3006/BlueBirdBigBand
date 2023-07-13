<template>
    <Contact class="w-1/2" email="bandleiter@bluebirdbigband.de" mobile="0171 5808481"
             name="Klaus Gehrlein" :bold_name="bold_name"/>
</template>

<script setup lang="ts">
import Contact from "@/Components/Contact.vue";
import {defineProps} from 'vue';

const props = defineProps<{ bold_name?: boolean }>();
</script>
