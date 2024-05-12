<template>
    <public-layout>
        <Heading>Auftritte</Heading>

        <div v-if="hasConcerts" class="flex flex-col gap-4">
            <Concert v-for="concert in concerts" :concert="concert"/>
        </div>

        <p v-if="!hasConcerts" class="text-justify">
            Aktuell sind keine Konzerte geplant.
        </p>
    </public-layout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {computed} from 'vue';
import Concert, {ConcertType} from "@/Components/Concert.vue";

const props = defineProps<{
    concerts: ConcertType[]
}>();

const hasConcerts = computed<boolean>(() => props.concerts.length > 0)

</script>

<style scoped>

</style>
