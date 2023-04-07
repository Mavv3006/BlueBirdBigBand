<template>
    <PublicLayout>
        <Heading>Rollen Management</Heading>
        <Head><title>Rollen Management</title></Head>

        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Aktionen</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="role in roles">
                <td>{{ role.id }}</td>
                <td>{{ role.name }}</td>
                <td>
                    <Link :href="`roles/${role.id}`" class="mr-1">Bearbeiten</Link>
                    <Link class="text-red-600">Löschen</Link>
                </td>
            </tr>
            </tbody>
        </table>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {defineProps} from 'vue';
import {Head, Link} from '@inertiajs/vue3';

const props = defineProps<{ roles: { id: number, name: string }[] }>();

console.debug(props);
</script>

<style scoped>
table {
    border-collapse: collapse;
    @apply w-full;
}

td, th {
    border: 1px solid #ddd;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

th {
    background-color: #04AA6D;
    @apply text-white py-2 text-left;
}
</style>
