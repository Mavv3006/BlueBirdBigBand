<template>
    <PublicLayout>
        <Heading>Rollen zuweisen</Heading>
        <Head><title>Rollen zuweisen</title></Head>

        <div class="m-auto md:w-1/2 lg:w-1/3">
            <div>
                <InputLabel for="username" value="User"/>
                <TextInput id="username" v-model="user.name" class="w-full mt-1" disabled type="text"/>
            </div>

            <form @submit.prevent="submit">
                <div class="block font-medium text-sm mt-4">Rollen</div>
                <div class="border border-gray-300 rounded-md p-2 pl-4 mt-1 flex flex-col gap-1">
                    <div v-for="role in roleMap">
                        <input
                            v-model="form.roles"
                            :checked="role.assigned"
                            :name="role.id"
                            :value="role.name"
                            class="rounded-sm border-gray-300 text-indigo-600 shadow-xs focus:ring-indigo-500"
                            type="checkbox"
                        />
                        <label :for="role.id" class="ml-2">{{ role.name }}</label>
                    </div>
                </div>
                <InputError v-if="form.errors.roles" :message="form.errors.roles" class="mt-2">
                    {{ form.errors.roles }}
                </InputError>

                <div class="mt-4 flex justify-center">
                    <PrimaryButton :disable="form.processing">Zuweisen</PrimaryButton>
                </div>
            </form>
        </div>

    </PublicLayout>
</template>

<script lang="ts" setup>
import {defineProps} from 'vue';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head, useForm} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps<{
    roleMap: {
        id: Number,
        name: String,
        assigned: Boolean
    }[],
    user: {
        name: String,
        id: Number
    }
}>();

const form = useForm({
    roles: props.roleMap
        .filter(value => value.assigned === true)
        .map(value => value.name)
})

const submit = () => {
    form.put(`/admin/assign-roles/user/${props.user.id}`)
}

</script>
