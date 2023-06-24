<template>
    <PublicLayout>
        <Head><title>Admin Startseite</title></Head>
        <Heading>Admin Startseite</Heading>

        <div>
            <div class="text-xl">Konzert Management</div>
            <div class="grid-container">
                <NavLink href="/admin/concerts">Alle Konzerte anzeigen</NavLink>
                <NavLink href="/admin/concerts/create">Konzert erstellen</NavLink>
            </div>
        </div>

    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from '@inertiajs/vue3';
import NavLink from "@/Components/Link/NavLink.vue";
</script>

<style scoped>
.grid-container {
    @apply grid-cols-3 grid gap-8 mt-2;
}
</style>
