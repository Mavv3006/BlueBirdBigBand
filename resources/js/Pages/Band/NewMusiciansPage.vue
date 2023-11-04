<template>
    <public-layout>
        <Head><title>Musiker</title></Head>

        <Heading>Musiker</Heading>

        <p class="text-justify mb-4">
            Hier finden Sie die aktuelle Besetzung der <span class="font-bold">Blue Bird Big Band</span>. Die <span
            class="font-bold">Blue Bird Big Band</span> probt immer mittwochs von 20:15 bis 22:00 Uhr. Aber nur
            außerhalb der
            <NavLink href="https://www.schulferien.org/Rheinland-Pfalz/rheinland-pfalz.html">Schulferien in
                Rheinland-Pfalz
            </NavLink>
            . Unsere <span class="font-bold">Dometown-Band</span> probt immer davor. Also mittwochs von 18:00 bis 20:00
            Uhr. Unter
            <NavLink href="/anfahrt">Anfahrt</NavLink>
            finden Sie noch einmal die Zeiten und die genaue Adresse, um zu unseren Proben zu finden.
        </p>

        <div class="flex flex-col gap-12">
            <NewMusicianInstrument
                v-for="musician in musicianWithInstrument"
                :instrument="musician.instrument"
                :musicians="musician.musicians"/>
        </div>

    </public-layout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import NavLink from "@/Components/Link/NavLink.vue";
import {Head} from '@inertiajs/vue3';
import {Musician, MusicianProp, MusicianWithInstrument} from "@/types/musician";
import NewMusicianInstrument from "@/Components/NewMusicianInstrument.vue";

const props = defineProps<{ data: MusicianProp[] }>();

const instrumentFilter = (instrument: string) => (value: MusicianProp): boolean => value.instrument.name === instrument;

const musicianMapping = (value: MusicianProp): Musician[] => value.musicians
    .sort((a, b) => a.lastname > b.lastname ? 1 : -1)
    .map((musician) => ({
        name: `${musician.firstname} ${musician.lastname}`,
    }));

const instrumentMapping = (instrument: string): MusicianWithInstrument => ({
    instrument: instrument,
    musicians: props.data
        .filter(instrumentFilter(instrument))
        .map(musicianMapping)[0]
});

const musicianWithInstrument = props.data.map((value) => instrumentMapping(value.instrument.name));
</script>
