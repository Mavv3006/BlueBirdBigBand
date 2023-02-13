<template>
    <public-layout>
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

        <div class="flex flex-col md:flex-row">
            <div class="w-1/2">
                <MusicianInstrument :musicians="bandleader" instrument="Bandleader"/>
            </div>
            <div class="w-1/2">
                <MusicianInstrument :musicians="vocals" instrument="Gesang"/>
            </div>
        </div>
        <MusicianInstrument :musicians="saxophones" instrument="Saxophone"/>
        <MusicianInstrument :musicians="trombones" instrument="Posaunen"/>
        <MusicianInstrument :musicians="trumpets" instrument="Trompeten"/>
        <MusicianInstrument :musicians="rhythms" instrument="Rhythmusgruppe"/>
    </public-layout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import NavLink from "@/Components/Link/NavLink.vue";
import MusicianInstrument, {Musician} from "@/Components/MusicianInstrument.vue";

// TODO: Add pictures of musicians
const bandleader: Musician[] = [
    {name: 'Klaus Gehrlein', picture: ''}
]
const vocals: Musician[] = [
    {name: 'Gabi Kipper', picture: '',},
    {name: 'Phillip Leschhorn', picture: ''}
]
const saxophones: Musician[] = [
    {name: 'Jutta Acker', picture: ''},
    {name: 'Niklas Piening', picture: ''},
    {name: 'Karin Kolb', picture: ''},
    {name: 'Edi Strobel', picture: ''},
    {name: 'Jürgen Höppchen', picture: ''},
    {name: 'Heiko Lübben', picture: ''},
    {name: 'Sabine Kolb', picture: ''},
]
const trombones: Musician[] = [
    {name: 'Michael Blessing', picture: ''},
    {name: 'Reinhold Paul', picture: ''},
    {name: 'Jürgen Illers', picture: ''},
]
const trumpets: Musician[] = [
    {name: 'Ursula Tremel', picture: ''},
    {name: 'Jürgen Scheidt', picture: ''},
    {name: 'Steffen Kolb', picture: ''},
    {name: 'Marvin Deuschle', picture: ''},
    {name: 'Benedikt Sommer', picture: ''},
]
const rhythms: Musician[] = [
    {name: 'Rudi Kolbinger (g)', picture: ''},
    {name: 'Hort Keller (p)', picture: ''},
    {name: 'Rudolf Schultz (bass)', picture: ''},
]
</script>
