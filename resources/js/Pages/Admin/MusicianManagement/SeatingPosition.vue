<template>
    <public-layout>
        <Head><title>Sitzposition bearbeiten</title></Head>
        <Heading>
            Sitzposition bearbeiten
        </Heading>

        <div v-for="prop in props.data" class="mb-8">
            <div class="text-bold text-xl mb-4">{{ prop.instrument.name }}</div>

            <ul class="gap-4 flex flex-col">
                <li v-for="musician in prop.musicians"
                    class="flex justify-between border rounded-md border-slate-400 py-2 px-4 mx-2 hover:shadow-md hover:border-slate-700">
                    <div>{{ musician.firstname }} {{ musician.lastname }}</div>
                    <div class="flex gap-6 text-slate-400">
                        <div>
                            <font-awesome-icon class="mr-1" icon="fa-solid fa-chevron-up"/>
                            Nach vorne
                        </div>
                        <div>
                            <font-awesome-icon class="mr-1" icon="fa-solid fa-chevron-down"/>
                            Nach hinten
                        </div>

                    </div>
                </li>
            </ul>
        </div>
    </public-layout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from '@inertiajs/vue3';
import {MusicianProp} from "@/types/musician";

const props = defineProps<{ data: MusicianProp[] }>();

</script>

<style scoped>

</style>
