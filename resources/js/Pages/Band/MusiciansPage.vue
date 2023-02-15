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

const picture_prefix = 'assets/musician_pictures/';
const default_tux = picture_prefix + 'default/tux.png';
const default_tux_sax = picture_prefix + 'default/tux-sax.jpg';
const default_tux_trumpet = picture_prefix + 'default/tux-trompeter.png';
const default_tux_guitar = picture_prefix + 'default/tux-gitarrist.png';
// const default_tux_drum = picture_prefix + 'default/tux-drummer.png';
// const default_tux_conductor = picture_prefix + 'default/tux-dirigent.png';

const bandleader: Musician[] = [
    {name: 'Klaus Gehrlein', picture: picture_prefix + 'gehrlein-klaus.jpg'}
]
const vocals: Musician[] = [
    {name: 'Gabi Kipper', picture: picture_prefix + 'kipper-gabi.jpeg',},
    {name: 'Phillip Leschhorn', picture: default_tux}
]
const saxophones: Musician[] = [
    {name: 'Jutta Acker', picture: picture_prefix + 'acker-jutta.jpeg'},
    {name: 'Niklas Piening', picture: default_tux_sax},
    {name: 'Karin Kolb', picture: default_tux_sax},
    {name: 'Edi Strobel', picture: default_tux_sax},
    {name: 'Jürgen Höppchen', picture: default_tux_sax},
    {name: 'Heiko Lübben', picture: picture_prefix + 'luebben-heiko.jpeg'},
    {name: 'Sabine Kolb', picture: default_tux_sax},
]
const trombones: Musician[] = [
    {name: 'Michael Blessing', picture: default_tux},
    {name: 'Reinhold Paul', picture: default_tux},
    {name: 'Jürgen Illers', picture: default_tux},
]
const trumpets: Musician[] = [
    {name: 'Ursula Tremel', picture: picture_prefix + 'tremel-ursel.jpeg'},
    {name: 'Jürgen Scheidt', picture: picture_prefix + 'scheid-juergen.jpeg'},
    {name: 'Steffen Kolb', picture: default_tux_trumpet},
    {name: 'Marvin Deuschle', picture: picture_prefix + 'deuschle-marvin.jpeg'},
    {name: 'Benedikt Sommer', picture: default_tux_trumpet},
]
const rhythms: Musician[] = [
    {name: 'Rudi Kolbinger (g)', picture: picture_prefix + 'kolbinger-rudi.jpeg'},
    {name: 'Hort Keller (p)', picture: picture_prefix + 'keller-horst.jpeg'},
    {name: 'Rudolf Schultz (bass)', picture: default_tux_guitar},
]
</script>
