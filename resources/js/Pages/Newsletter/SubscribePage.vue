<template>
    <NewsletterLayout>
        <Head title="Vielen Dank! 🎉"/>

        <div class="mx-auto max-w-lg md:max-w-xl lg:max-w-2xl xl:max-w-3xl">
            <NewsletterSubscribe title="Eintragen in Newsletter"/>
        </div>
    </NewsletterLayout>
</template>

<script setup lang="ts">
import NewsletterLayout from "@/Layouts/NewsletterLayout.vue";
import {Head} from "@inertiajs/vue3";
import NewsletterSubscribe from "@/Components/Newsletter/NewsletterSubscribe.vue";
</script>

<style scoped>
</style>
