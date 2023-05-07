<template>
    <PublicLayout>
        <Head>
            <title>Admin - User aktivieren</title>
        </Head>
        <Heading>User aktivieren</Heading>

        <table class="mx-auto w-1/3">
            <thead>
            <tr>
                <th class="w-1/5">ID</th>
                <th class="w-2/5">Name</th>
                <th class="w-2/5">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users">
                <td class="w-1/5">{{ user.id }}</td>
                <td class="w-2/5">{{ user.name }}</td>
                <td class="w-2/5">
                    <Link method="patch" :href="'/admin/activate-users/'+user.id"> Aktivieren</Link>
                </td>
            </tr>
            </tbody>
        </table>
    </PublicLayout>
</template>

<script lang="ts" setup>
import {defineProps} from 'vue';
import {Head, Link} from '@inertiajs/vue3';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";

const props = defineProps<{
    users: {
        id: Number,
        name: String,
    }[],
}>();
</script>

<style scoped>
td, th {
    border-bottom: 1px solid #999;
    @apply text-center py-2;
}
</style>
