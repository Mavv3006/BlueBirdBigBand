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
                <td>
                    <Link :href="`roles/${role.id}`" class="text-blue-600 mr-1 hover:underline">
                        {{ role.name }}
                    </Link>
                </td>
                <td class="flex flex-wrap gap-4">
                    <Link :href="`roles/${role.id}/edit`" class="mr-1">
                        <font-awesome-icon icon="fa-solid fa-pen"/>
                    </Link>
                    <Link :href="`roles/${role.id}`" method="delete" class="text-red-600">
                        <font-awesome-icon icon="fa-solid fa-trash"/>
                    </Link>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="flex justify-end mt-4">
            <Link href="roles/create"
                  class="border border-slate-700 shadow-md hover:shadow-xl rounded-full w-12 h-12 flex justify-center items-center hover:bg-gray-200 active:bg-gray-300">
                <font-awesome-icon :icon="['fas', 'plus']"/>
            </Link>
        </div>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {defineProps} from 'vue';
import {Head, Link} from '@inertiajs/vue3';

const props = defineProps<{ roles: { id: number, name: string }[] }>();
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
