<template>
    <PublicLayout>
        <Heading>Song bearbeiten</Heading>
        <Head><title>Song bearbeiten</title></Head>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                <div>
                    <InputLabel for="title" value="Titel des Songs"/>
                    <TextInput v-model="form.title" class="w-full mt-1" name="title" required type="text"/>
                    <InputError :message="form.errors.title" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="author" value="Autor des Songs"/>
                    <TextInput v-model="form.author" class="w-full mt-1" name="author" required type="text"/>
                    <InputError :message="form.errors.title" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="arranger" value="Arrangeur des Songs"/>
                    <TextInput v-model="form.arranger" class="w-full mt-1" name="arranger" required type="text"/>
                    <InputError :message="form.errors.title" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="genre" value="Genre des Songs"/>
                    <TextInput v-model="form.genre" class="w-full mt-1" name="genre" required type="text"/>
                    <InputError :message="form.errors.title" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="file" value="Song-Datei"/>
                    <input class="mt-1" name="file" type="file" @input="form.file = $event.target.files[0]"/>
                    <InputError :message="form.errors.file" class="mt-2"/>
                </div>
            </div>

            <div class="mt-2 flex justify-center">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Speichern
                </PrimaryButton>
            </div>
        </form>
    </PublicLayout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps<{
    song: {
        id: number,
        file_path?: string,
        title: string,
        arranger: string,
        author: string,
        genre: string
    }
}>();

const form = useForm({
    _method: 'put',
    title: props.song.title,
    author: props.song.author,
    arranger: props.song.arranger,
    genre: props.song.genre,
    file: props.song.file_path ?? null
});

const submit = () => form.post(`/admin/songs/${props.song.id}`);

</script>
