<template>
    <PublicLayout>
        <Heading>Neue Rolle erstellen</Heading>
        <Head><title>Neue Rolle erstellen</title></Head>

        <form class="mx-auto sm:w-7/12 md:w-6/12 lg:w-5/12 xl:w-4/12" @submit.prevent="submit">
            <div>
                <InputLabel for="role_name" value="Rollenname"/>
                <TextInput
                    id="role_name"
                    v-model="form.name"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="text"
                />
                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div class="flex items-center justify-center mt-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Speichern
                </PrimaryButton>
            </div>
        </form>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    name: '',
});

const submit = () => {
    form.post(route('roles.store'));
};
</script>
