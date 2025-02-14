<template>
    <PublicLayout>
        <Heading>Alle Konzerte</Heading>
        <Head><title>Alle Konzerte</title></Head>

        <div class="flex flex-col gap-8 lg:flex-row lg:gap-16 lg:justify-center">
            <div>
                <h2>Anstehende Konzerte</h2>
                <AdminConcertList :concerts="concerts.upcoming"/>
            </div>

            <div>
                <h2>Vergangene Konzerte</h2>
                <AdminConcertList :concerts="concerts.past"/>
            </div>
        </div>

    </PublicLayout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from '@inertiajs/vue3';
import AdminConcertList from "@/Components/AdminConcertList.vue";
import {Concert as ConcertType} from "@/types/concert";

const props = defineProps<{
    concerts: {
        upcoming: ConcertType[],
        past: ConcertType[]
    }
}>();
</script>

<style scoped>
@reference "tailwindcss";
h2 {
    @apply text-[1em] leading-normal text-center w-full inline-block mb-[0.5em] text-[#3d4449] font-bold md:text-[1.25em] md:text-left lg:text-[1.5em] 2xl:font-[2175em] 2xl:leading-snug;
}
</style>
