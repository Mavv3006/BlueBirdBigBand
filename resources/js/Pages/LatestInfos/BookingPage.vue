<template>
    <public-layout>
        <Head title="Buchungsinfos"/>

        <Heading>Buchungsinfos</Heading>

        <div class="flex flex-col gap-4">
            <p>Die Blue Bird Big Band bietet Ihnen hochwertigen Bigband-Jazz für jeden Anlass, z.B.</p>

            <ul>
                <li>Messen</li>
                <li>Betriebsfeste</li>
                <li>Jubiläen</li>
                <li>Frühshoppen</li>
                <li>sonstige Feste</li>
            </ul>

            <p>Wir können sie an fast jedem Ort unterhalten. Wir benötigen hierzu:</p>

            <ul>
                <li>eine Bühne, mindestens 8 m breit und 6 m tief</li>
                <li>~ 20 Stühle</li>
                <li>220 V Stromanschluss</li>
                <li>Schutz vor Sonne und Regen bei Open-Air Veranstaltungen</li>
            </ul>

            <p>Interessiert Sie unser Angebot? Setzen Sie sich mit uns in Verbindung!</p>

            <div>Weitere Infos erhalten Sie bei</div>

            <ContactBandleader bold_name/>
            <ContactManagement bold_name/>
        </div>
    </public-layout>
</template>

<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import ContactBandleader from "@/Components/Contact/ContactBandleader.vue";
import ContactManagement from "@/Components/Contact/ContactManagement.vue";
import {Head} from '@inertiajs/vue3';</script>

<style scoped>
p {
    @apply font-semibold;
}

ul {
    @apply list-disc pl-4;
}
</style>
