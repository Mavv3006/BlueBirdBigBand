<template>
    <NewsletterLayout>
        <Head title="Vielen Dank! 🎉"/>

        <h1 class="text-[2em] leading-normal text-center w-full inline-block mb-[0.5em] text-[#3d4449] font-bold md:text-[2.25em] md:text-left  2xl:leading-snug">
            Vielen Dank! 🎉
        </h1>
        <div class="flex flex-col gap-2">
            <p>
                Deine E-Mail-Adresse wurde erfolgreich bestätigt.
            </p>
            <p>
                Du wirst nun in unseren Newsletter aufgenommen und erhältst ab sofort Infos zu unseren nächsten
                Auftritten direkt in dein Postfach.

            </p>
            <p>
                Wir freuen uns, dich dabei zu haben!
            </p>
            <p class="font-bold">
                Du kannst das Fenster nun schließen.
            </p>
        </div>
    </NewsletterLayout>
</template>

<script lang="ts" setup>
import NewsletterLayout from "@/Layouts/NewsletterLayout.vue";
import {Head} from "@inertiajs/vue3";
</script>

<style scoped>

</style>
