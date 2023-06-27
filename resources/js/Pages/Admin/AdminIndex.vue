<template>
    <PublicLayout>
        <Head><title>Admin Startseite</title></Head>
        <Heading>Admin Startseite</Heading>

        <div class="flex gap-8 flex-col">
            <div>
                <div class="text-xl">Konzert Management</div>
                <div class="grid-container">
                    <NavLink href="/admin/concerts">Alle Konzerte anzeigen</NavLink>
                    <NavLink href="/admin/concerts/create">Neues Konzert anlegen</NavLink>
                </div>
            </div>

            <div>
                <div class="text-xl">Rollen Management</div>
                <div class="grid-container">
                    <NavLink href="/admin/roles">Alle Rollen anzeigen</NavLink>
                    <NavLink href="/admin/roles/create">Neue Rolle anlegen</NavLink>
                </div>
            </div>

            <div>
                <div class="text-xl">Musiker Management</div>
                <div class="grid-container">
                    <NavLink href="/admin/musicians">Alle Musiker anzeigen</NavLink>
                    <NavLink href="/admin/musicians/create">Neuen Musiker anlegen</NavLink>
                    <NavLink href="/admin/seating-position">Sitzposition ändern</NavLink>
                </div>
            </div>

            <div>
                <div class="text-xl">Song Management</div>
                <div class="grid-container">
                    <NavLink href="/admin/songs">Alle Songs anzeigen</NavLink>
                    <NavLink href="/admin/songs/create">Neuen Song anlegen</NavLink>
                </div>
            </div>

            <div>
                <div class="text-xl">User Management</div>
                <div class="grid-container">
                    <NavLink href="/admin/activate-users">User aktivieren</NavLink>
                    <NavLink href="/admin/assign-roles">Rollen zuweisen</NavLink>
                </div>
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
    @apply grid-cols-1 gap-y-2 gap-x-8 grid mt-2 sm:grid-cols-2 md:grid-cols-3 md:gap-12 lg:gap-16;
}
</style>
