<template>
    <PublicLayout>
        <Heading>Musiker bearbeiten</Heading>
        <Head><title>Musiker bearbeiten</title></Head>

        <form @submit.prevent="submit">
            <div class="grid grid-rows-2 gap-4">
                <div class="grid grid-cols-2 gap-16 w-full">
                    <div>
                        <InputLabel for="firstname" value="Vorname"/>
                        <TextInput
                            id="firstname"
                            v-model="form.firstname"
                            autofocus
                            class="mt-1 block w-full"
                            required
                            type="text"
                        />
                        <InputError :message="form.errors.firstname" class="mt-2"/>
                    </div>
                    <div>
                        <InputLabel for="lastname" value="Nachname"/>
                        <TextInput
                            id="lastname"
                            v-model="form.lastname"
                            class="mt-1 block w-full"
                            required
                            type="text"
                        />
                        <InputError :message="form.errors.lastname" class="mt-2"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-16 w-full">
                    <div>
                        <InputLabel for="instrument" value="Instrument"/>
                        <select
                            id="instrument"
                            v-model="form.instrument_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            name="instrument"
                            required>
                            <option
                                v-for="instrument in instruments"
                                :disabled="instrument.id===0"
                                :value="instrument.id"
                            >
                                {{ instrument.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.instrument_id" class="mt-2"/>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center mt-4 gap-8">
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
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps<{
    musician: {
        id: number,
        firstname: string,
        lastname: string,
        picture_filepath?: string,
        isActive: boolean,
        instrument_id: number
    },
    instruments: { name: string, id: number }[]
}>();

const form = useForm({
    firstname: props.musician.firstname,
    lastname: props.musician.lastname,
    instrument_id: props.musician.instrument_id,
});

const submit = () => {
    console.debug(form.data());
    form.put(route('musicians.update', {'musician': props.musician.id}))
};

</script>
<style scoped>

</style>
