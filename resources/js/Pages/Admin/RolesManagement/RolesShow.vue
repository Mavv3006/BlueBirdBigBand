<template>
    <PublicLayout>
        <Heading>Rolle anzeigen: {{ role.name }}</Heading>
        <Head><title>Rolle {{ role.name }}</title></Head>

        <div class="md:flex md:flex-row md:gap-8">
            <div class="w-full mb-4 md:mb-0 md:w-1/2">
                <h2 class="mb-4">Permissions</h2>
                <table>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="permission in role_permissions">
                        <td>{{ permission.id }}</td>
                        <td>{{ permission.name }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="w-full md:w-1/2">
                <h2 class="mb-4">Users</h2>
                <table>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Activated</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.activated }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from '@inertiajs/vue3';
import {defineProps} from 'vue';

const props = defineProps<{
    role: { id: number, name: string },
    role_permissions: { id: number, name: string }[],
    users: { id: number, name: string, activated: boolean }[],
}>();
</script>

<style scoped>
@reference "tailwindcss";
h2 {
    @apply text-2xl
}

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
