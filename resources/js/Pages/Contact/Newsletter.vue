<template>
    <public-layout>
        <Head title="Newsletter"></Head>

        <Heading> Newsletter</Heading>

        <div>
            Hier können Sie sich für unseren Konzert-Newsletter eintragen bzw. austragen.
        </div>

        <div class="mt-8 flex gap-y-12 flex-col mx-auto max-w-lg md:max-w-xl lg:max-w-2xl xl:max-w-3xl">
            <section>
                <NewsletterSubscribe title="Eintragen"/>
            </section>

            <hr>

            <section>
                <NewsletterUnsubscribe/>
            </section>
        </div>
    </public-layout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import {Head} from "@inertiajs/vue3";
import Heading from "@/Components/Heading.vue";
import NewsletterSubscribe from "@/Components/Newsletter/NewsletterSubscribe.vue";
import NewsletterUnsubscribe from "@/Components/Newsletter/NewsletterUnsubscribe.vue";
</script>
