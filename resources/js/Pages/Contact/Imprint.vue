<template>
    <public-layout>
        <Heading>Impressum</Heading>

        <div class="flex flex-col gap-2 mb-4 md:flex-row md:gap-8 lg:gap-12 xl:gap-16 2xl:gap-20">
            <div class="w-1/2 md:text-right">
                <p class="font-bold">Klaus Gehrlein</p>
                <p>Rheinhäuserstr. 24</p>
                <p>68165 Mannheim</p>
                <p>Deutschland</p>
            </div>

            <div class="w-1/2">
                <p>Telefon: 0621 409497</p>
                <p>Telefax: 0621 3197488</p>
                <p>Mobil: 0171 5808481</p>
                <p>E-Mail:
                    <NavLink href="mailto:bandleiter@bluebirdbigband.de">
                        bandleiter@bluebirdbigband.de
                    </NavLink>
                </p>
            </div>
        </div>

        <div class="text-sm flex flex-col gap-4 text-justify">
            <div>
                <p class="font-bold underline">Urheberrecht</p>
                <p>
                    Der Inhalt dieser Website ist urheberrechtlich geschützt. Alle Rechte, auch die der Übersetzung, des
                    Nachdrucks und der Vervielfältigung des Inhalts oder Teilen daraus, sind vorbehalten. Ohne
                    schriftliche Genehmigung seitens der Blue Bird Bigband darf der Inhalt dieser Seite in keiner Form
                    (Fotokopie, Mikrofilm oder einem anderen Verfahren), auch nicht zum Zwecke der
                    Unterrichtsgestaltung, reproduziert oder unter Verwendung elektronischer Systeme verarbeitet,
                    vervielfältigt oder verbreitet werden. Ausgenommen davon ist - vorausgesetzt es wird keine Änderung
                    am Inhalt der Website vorgenommen - die Verwendung des Inhalts zu persönlichen und
                    nichtkommerziellen Zwecken. Diese Erlaubnis endet, wenn gegen die oben genannten Bedingungen
                    verstoßen wird.
                </p>
            </div>

            <div>
                <p class="font-bold underline">Links auf andere Websites</p>
                <p>
                    Für Verlinkungen auf fremde Seiten und dessen Inhalt übernehmen wir keine Verantwortung. Hiermit
                    distanzieren wir uns ausdrücklich von allen Inhalten aller gelinkten Seiten auf unserer Homepage und
                    machen uns diese Inhalte nicht zu eigen. Diese Erklärung gilt für alle auf unserer Homepage
                    angebrachten Links. (gemäß Urteil vom 12. Mai 1998 - 312 O 85/98 - "Haftung für Links" / Landgericht
                    Hamburg).
                </p>
            </div>
        </div>
    </public-layout>
</template>

<script setup>

import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import NavLink from "@/Components/NavLink.vue";</script>
