<template>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in users">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>
                <Link :href="'/admin/activate-users/'+user.id">Aktivieren</Link>
            </td>
        </tr>
        </tbody>
    </table>

</template>

<script lang="ts" setup>
import {computed, defineProps} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps<{
    users: {
        id: Number,
        name: String,
    }[],
}>();

console.debug(props.users);

</script>

<style scoped></style>
