<template>
    <public-layout>
        <Heading>Big Band Jazz</Heading>

        <img
            class="block mx-auto md:float-right md:m-0 md:w-[60%] md:max-w-[430px]"
            src="storage/images/bbband.jpg"
            alt="Gruppenbild der Blue Bird Big Band"
        />

        <p>
            Im Rahmen der Städtischen Musikschule Speyer haben sich im Frühjahr 1993 etwas mehr als 20 Musiker und
            Musikerinnen unter der Leitung von Herrn Klaus Gehrlein zur Gründung einer Jazz-Big-Band zusammengefunden.
            Mittlerweile sind ca. 20 Musiker und Musikerinnen daraus geworden.
        </p>

        <p>
            Alle Altersstufen sind darin vertreten, der Jüngste ist 12, der älteste über 70 Jahre alt. Die größte
            Mehrheit der Bigband-Mitglieder zählt allerdings zwischen 25 und 45 Lenze. Es handelt sich bei der BLUE BIRD
            BIG BAND um eine Amateur-Band jedoch mit akademischen Anspruch, die quasi unter anderem Sprungbrett -
            Plattform für angehende Klassik- und Jazz-Studenten der Musikhochschule sein soll, geprägt vom Spaß an der
            Musik.
        </p>

        <p>
            Aber auch Wiedereinsteiger und leicht Fortgeschrittene sind bei uns herzlich willkommen. Für sie haben wir
            eigens eine Midi-BlueBirdBigBand gegründet. In nicht all zu ferner Zukunft, soll auch noch eine
            Mini-BlueBirdBigBand gegründet werden um auch dem absoluten Anfänger, ab 6-9 Monate Unterricht, die
            Möglichkeit zu geben, sehr früh Jazz-Bigband in ganz kleinen Schritten kennenzulernen.
        </p>

        <p>
            Die Maxi-BBBB hält 1-2 mal pro Jahr Ihren Workshop bei dem sie Dozenten der Jazz-Szene hinzuzieht.
            Entsprechend vielfältig gestaltet sich daher auch unser Repertoire. Von Duke Ellington's und Count Basie's
            Swing der 40-er Jahre, über Charlie Parker und Dizzy Gillespie, bis hin zu neuzeitlichen Komponisten wie
            Chick Corea, Herbie Hancock und Peter Herbolzheimer spannt sich unser musikalischer Bogen.
        </p>

        <p>
            Die Band gibt Konzerte, auch im Ausland (Frankreich, Kroatien), wird von Gemeindeverwaltungen, Vereinen,
            Firmen und sonstigen Organisationen engagiert für Feste, Weihnachtsmärkte und diverse Veranstaltungen, war
            schon mehrmals beim Rheinland-Pfalz-Tag, bei der Landesgartenschau und Open-Sound in
            Mannheim/Ludwigshafen/Heidelberg. Die Stadtverwaltung Speyer braucht die Band immer wieder zu hoch
            offiziellen Veranstaltungen.
        </p>

        <ul>
            <li>
                1997 Konzertreise Kroatien (10 Tage mit dem Segelschiff, jeden Abend ein Hafenkonzert im neuen Hafen)
            </li>
            <li>
                1998 Konzertreise Frankreich Le Mans, The egg of Jazz (l'oeuf de jazz)
            </li>
            <li>
                1999 Teilnahme am Landesorchester-Wettbewerb Rheinland-Pfalz, mit gutem Erfolg
            </li>
            <li>
                2002 beim Skoda-Jazz-Bigband-Wettbewerb in Worms 2. Platz
            </li>
            <li>
                2003 erneut beim Landesorchesterwettbewerb Rheinland-Pfalz als Sieger der Kategorie E1
            </li>
            <li>
                2004 beim Bundesorchesterwettbewerb in Osnabrück 7. Platz
            </li>
        </ul>

        <footer>
            Autor:
            <NavLink href="/kontakt">Klaus Gehrlein</NavLink>
        </footer>
    </public-layout>
</template>

<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import NavLink from "@/Components/NavLink.vue";</script>

<style scoped>
p {
    @apply text-justify;
}

p, ul {
    @apply mb-6;
}

ul li:not(ul li:last-child) {
    @apply mb-2;
}
</style>
