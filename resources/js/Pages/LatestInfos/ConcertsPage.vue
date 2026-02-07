<template>
    <public-layout>
        <Head><title>Auftritte</title></Head>

        <Heading>Auftritte</Heading>

        <div class="flex flex-col gap-4">
            <section>
                <div v-if="hasConcerts" class=" justify-evenly flex flw-row gap-4 flex-wrap">
                    <Concert class="w-md bg-[#04128610] p-2 rounded-xl" v-for="concert in concerts" :concert="concert"/>
                </div>

                <p v-if="!hasConcerts" class="text-justify">
                    Aktuell sind keine Konzerte geplant.
                </p>
            </section>

            <hr class="border-[#041286]">

            <section>
                <h2>Pressestimmen</h2>

                <ul class="list-disc pl-4">
                    <li>
                        <ExternalLink
                            href="assets/pressreports/2026/2026_rheinpfalz_nr20_neujahrsempfang.jpeg">
                            Rheinpfalz Speyer Nr. 20 2026 (Samstag, 24. Januar 2026)
                        </ExternalLink>
                    </li>
                    <li>
                        <ExternalLink
                            href="assets/pressreports/2026/2026_rheinpfalz_nr21_neujahrsempfang.jpeg">
                            Rheinpfalz Speyer Nr. 21 2026 (Montag, 26. Januar 2026)
                        </ExternalLink>
                    </li>
                </ul>
            </section>
        </div>
    </public-layout>
</template>

<script lang="ts" setup>
import {Head} from '@inertiajs/vue3';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {computed} from 'vue';
import Concert, {ConcertType} from "@/Components/Concert.vue";
import ExternalLink from "@/Components/Link/ExternalLink.vue";

const props = defineProps<{
    concerts: ConcertType[]
}>();

const hasConcerts = computed<boolean>(() => props.concerts.length > 0)

</script>
