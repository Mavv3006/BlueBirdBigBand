<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, useForm} from '@inertiajs/vue3';
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    name: '',
    password: '',
    remember: false, // TODO:remove remember
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <PublicLayout>
        <Head title="Log in"/>

        <Heading>Login</Heading>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form class="mx-auto sm:w-7/12 md:w-6/12 lg:w-5/12 xl:w-4/12" @submit.prevent="submit">
            <div>
                <InputLabel for="username" value="Benutzername"/>

                <TextInput
                    id="username"
                    v-model="form.name"
                    autocomplete="username"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="text"
                />

                <InputError :message="form.errors.email" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Passwort"/>

                <TextInput
                    id="password"
                    v-model="form.password"
                    autocomplete="current-password"
                    class="mt-1 block w-full"
                    required
                    type="password"
                />

                <InputError :message="form.errors.password" class="mt-2"/>
            </div>

            <div class="flex items-center justify-center mt-4">
                <!--                <Link-->
                <!--                    v-if="canResetPassword"-->
                <!--                    :href="route('password.request')"-->
                <!--                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"-->
                <!--                >-->
                <!--                    Forgot your password?-->
                <!--                </Link>-->

                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                    Login
                </PrimaryButton>
            </div>
        </form>
    </PublicLayout>
</template>
