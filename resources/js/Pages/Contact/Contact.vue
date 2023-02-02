<template>
    <public-layout>
        <Heading>
            Kontakt
        </Heading>

        <div class="flex flex-col gap-8">
            <div class="inline-flex items-center justify-center gap-8 lg:gap-12 xl:gap-16 2xl:gap-20">
                <p class="text-right font-bold w-1/2">Bandleader:</p>
                <Contact class="w-1/2" email="bandleiter@bluebirdbigband.de" mobile="0171 5808481"
                         name="Klaus Gehrlein" telefax="0621 3197488" telephon="0621 409497"/>
            </div>

            <div class="inline-flex items-center justify-center gap-8 lg:gap-12 xl:gap-16 2xl:gap-20">
                <p class="text-right font-bold w-1/2">Management und Buchung:</p>
                <Contact class="w-1/2" email="buchung@bluebirdbigband.de" name="Rudi Kolbinger"
                         telephon="06232 621915"/>
            </div>

            <div class="inline-flex items-center justify-center gap-8 lg:gap-12 xl:gap-16 2xl:gap-20">
                <p class="text-right font-bold w-1/2">Internet:</p>
                <Contact class="w-1/2" email="webadmin@bluebirdbigband.de" name="Webadmin"/>
            </div>
        </div>
    </public-layout>
</template>
<script setup>
import Heading from "@/Components/Heading.vue";
import Contact from "@/Components/Contact.vue";
import PublicLayout from "@/Layouts/PublicLayout.vue";</script>
