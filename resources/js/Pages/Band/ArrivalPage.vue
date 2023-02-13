<template>
    <public-layout>
        <Head title="Anfahrt"/>
        <Heading>Wegbeschreibung zur Probe</Heading>

        <div class="flex flex-col gap-8">
            <p>
                Probe ist jeden Mittwoch - außer in den Schulferien (
                <NavLink href="https://www.schulferien.org/Rheinland-Pfalz/rheinland-pfalz.html"> Ferientermine
                    Rheinland-Pfalz
                </NavLink>
                ) - im Unterrichtsraum 115 im 1. OG der Musikschule der Stadt Speyer. Die <span class="font-bold">Einsteiger-Dometown-Big Band</span>
                probt von 18:15 bis 20:00 Uhr, die <span class="font-bold">BlueBirdBigBand</span> von 20:15 bis 22:00
                Uhr.
            </p>

            <div>
                <p class="font-bold underline">Die Adresse lautet:</p>
                <p>Musikschule der Stadt Speyer</p>
                <p>Mausbergweg 144</p>
                <p>67346 Speyer</p>
            </div>

            <div class="w-[85%] h-[400px] m-auto lg:w-[800px] lg:h-[600px]">
                <iframe allowfullscreen class="w-full h-full" height="600"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2600.3175892804056!2d8.432908116445535!3d49.32720577933624!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4797b69c0432edc1%3A0xa304f0208640358c!2sMusikschule+der+Stadt+Speyer!5e0!3m2!1sde!2sde!4v1475013688535">
                </iframe>
            </div>

            <div class="text-center">
                <NavLink
                    href="https://www.google.de/maps/place/Musikschule+der+Stadt+Speyer/@49.3272058,8.4329081,17z/data=!3m1!4b1!4m5!3m4!1s0x4797b69c0432edc1:0xa304f0208640358c!8m2!3d49.3272058!4d8.4350968?hl=de"
                    target="_blank">
                    Größere Kartenansicht
                </NavLink>
            </div>
        </div>
    </public-layout>
</template>

<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import NavLink from "@/Components/Link/NavLink.vue";
import {Head} from '@inertiajs/vue3';</script>

<style scoped>
p {
    @apply text-justify
}
</style>
