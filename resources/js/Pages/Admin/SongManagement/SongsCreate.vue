<template>
    <PublicLayout>
        <Heading>Song erstellen</Heading>
        <Head><title>Song erstellen</title></Head>

        <form @submit.prevent="submitForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="title" value="Titel des Songs"/>
                    <TextInput class="w-full mt-1" v-model="form.title" name="title" required type="text"/>
                    <InputError class="mt-2" :message="form.errors.title"/>
                </div>

                <div>
                    <InputLabel for="author" value="Autor des Songs"/>
                    <TextInput class="w-full mt-1" v-model="form.author" name="author" required type="text"/>
                    <InputError class="mt-2" :message="form.errors.title"/>
                </div>

                <div>
                    <InputLabel for="arranger" value="Arrangeur des Songs"/>
                    <TextInput class="w-full mt-1" v-model="form.arranger" name="arranger" required type="text"/>
                    <InputError class="mt-2" :message="form.errors.title"/>
                </div>

                <div>
                    <InputLabel for="genre" value="Genre des Songs"/>
                    <TextInput class="w-full mt-1" v-model="form.genre" name="genre" required type="text"/>
                    <InputError class="mt-2" :message="form.errors.title"/>
                </div>

                <div>
                    <InputLabel for="file" value="Song-Datei"/>
                    <input name="file" type="file" @input="form.file = $event.target.files[0]"/>
                    <InputError :message="form.errors.file" class="mt-2"/>
                </div>
            </div>

            <div>
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
import {Head, useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue"
import TextInput from "@/Components/TextInput.vue"
import InputError from "@/Components/InputError.vue"
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    _method: 'post',
    title: '',
    author: '',
    arranger: '',
    genre: '',
    file: null
});

const submitForm = () => {
    form.post(`admin/songs/`);
}
</script>

<style scoped>

</style>
