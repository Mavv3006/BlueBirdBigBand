<template>
    <public-layout>
        <Heading>User suchen</Heading>
        <Head><title>User suchen</title></Head>

        <form class="flex flex-col md:w-1/2 lg:w-1/3 m-auto" @submit.prevent="submit">
            <div>
                <InputLabel for="username" value="Username:"/>
                <TextInput id="username" v-model="form.username" class="w-full mt-2" required type="text"/>
                <InputError v-if="errors.username" :message="errors.username" class="mt-2"> {{
                        form.errors.username
                    }}
                </InputError>
            </div>

            <div class="m-auto mt-6">
                <PrimaryButton :disabled="form.processing">Suchen</PrimaryButton>
            </div>
        </form>
    </public-layout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head, useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    username: '',
});

const props = defineProps({errors: Object});

const submit = () => {
    form.get('/admin/assign-roles');
}
</script>
