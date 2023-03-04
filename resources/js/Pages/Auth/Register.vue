<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, useForm} from '@inertiajs/vue3';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";

const form = useForm({
    name: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

defineProps({
    status: String
})

const submit = () => {
    form.post(route('register'), {
        onSuccess: () => form.reset('name', 'password', 'password_confirmation'),
        onError: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <PublicLayout>
        <Head><title>Registrieren</title></Head>
        <Heading>Registrieren</Heading>

        <p>
            Nach dem erfolgreichen Registrieren, muss Ihr Account erst noch von einem Administrator freigeschaltet
            werden, bevor Sie sich mit ihrem Benutzernamen und Passwort einloggen können.
        </p>

        <form class="mx-auto sm:w-7/12 md:w-6/12 lg:w-5/12 xl:w-4/12" @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Benutzername"/>

                <TextInput
                    id="name"
                    v-model="form.name"
                    autocomplete="username"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="text"
                />

                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Passwort"/>

                <TextInput
                    id="password"
                    v-model="form.password"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    required
                    type="password"
                />

                <InputError :message="form.errors.password" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Passwort bestätigen"/>

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    required
                    type="password"
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2"/>
            </div>

            <div class="flex flex-col items-center justify-center mt-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrieren
                </PrimaryButton>

                <div v-if="status" class="mt-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>
            </div>
        </form>
    </PublicLayout>
</template>
