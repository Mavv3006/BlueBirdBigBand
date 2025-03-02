<template>
    <public-layout>
        <Head title="Über uns"/>

        <Heading>Die Blue Bird Big Band</Heading>

        <p class="mb-6 text-justify">
            Die Blue Bird Big Band der Musikschule Speyer bringt satten, typischen Big Band Sound auf die Bühne. Die
            Band, das sind 25 Jazz-Enthusiasten zwischen 13 und 70 unter der Leitung von Klaus „Tiny“ Gehrlein, der das
            Ensemble 1993 gründete.
        </p>

        <p class="mb-6 text-justify">
            Wir spielen in der klassischen Big Band Besetzung mit Trompeten, Posaunen, Saxofonen und Rhythmusgruppe,
            verstärkt von den Sängern Gabi und Phillip.
        </p>

        <p class="mb-6 text-justify">
            Unser Repertoire umfasst Swing, Latin und Funk, gefühlvolle Balladen und fetzige Bläsersätze, expressive
            Soli und groovende Rhythmen.
        </p>

        <p class="mb-6 text-justify">
            Als Amateurmusiker mit hohem musikalischen Anspruch spielen wir auf öffentlichen und privaten
            Veranstaltungen, auf Stadtfesten, in Weingütern und zu Jubiläen von Vereinen und Clubs, zuletzt auf dem
            Neujahrsempfang der Stadt Speyer.
        </p>

        <p class="mb-6 text-justify">
            Ein musikalisches Highlight in der Region ist seit 23 Jahren „Swing im Dreieck“, ein gemeinsames Konzert mit
            den Big Bands der Musikschulen aus Mannheim und Ludwigshafen.
        </p>

        <p class="mb-6 text-justify">
            In der Adventszeit erklingt unser stimmungsvolles Weihnachtsprogramm in Kirchen der Umgebung.
        </p>

        <p class="mb-6 text-justify">
            Für diesen Sommer planen wir eine heiße „Latin Night“ mit lateinamerikanische Rhythmen (Salsa, Samba,
            Cha-Cha-Cha) zum Tanzen.
        </p>

        <p class="mb-6 text-justify">
            Unsere aktuellen Auftrittstermine finden Sie auf der Homepage unter
            <NavLink :href="route('concerts')">„Aktuelles / Auftritte“</NavLink>
            .
        </p>

        <p class="mb-6 text-justify">
            Kontakt:
            <NavLink href="/kontakt">Klaus Gehrlein</NavLink>
            , Mobil: 0171 5808481, E-Mail:
            <MailtoLink mail-adress="bandleiter@bluebirdbigband.de">bandleiter@bluebirdbigband.de</MailtoLink>
        </p>

        <img
            alt="Gruppenbild der Blue Bird Big Band"
            class="w-[90%] md:w-[80%] lg:w-[70%] block mx-auto my-4"
            src="assets/grouppictures/2023-05-07-mini.jpg"
        >
    </public-layout>
</template>

<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import NavLink from "@/Components/Link/NavLink.vue";
import {Head} from '@inertiajs/vue3';
import MailtoLink from "@/Components/Link/MailtoLink.vue";</script>
