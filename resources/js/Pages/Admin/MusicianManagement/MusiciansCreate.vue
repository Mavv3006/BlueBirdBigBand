<template>
    <PublicLayout>
        <Heading>Neuen Musiker anlegen</Heading>

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
                        <InputLabel for="part" value="Stimme"/>
                        <select
                            name="part"
                            id="part"
                            required
                            v-model="form.part"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            >
                            <option v-for="part in part_list" :value="part.value">{{ part.text }}</option>
                        </select>
                        <InputError :message="form.errors.part" class="mt-2"/>
                    </div>
                    <div>
                        <InputLabel for="instrument" value="Instrument"/>
                        <select
                            name="instrument"
                            id="instrument"
                            required
                            v-model="form.instrument_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option
                                v-for="instrument in instruments"
                                :value="instrument.id"
                                :disabled="instrument.id===0"
                            >
                                {{ instrument.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.instrument_id" class="mt-2"/>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center mt-4 gap-8">
                <SecondaryButton @click="cancelForm()">Abbrechen</SecondaryButton>
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
import TextInput from "../../../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Components/TextInput.vue";
import InputLabel
    from "../../../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Components/InputLabel.vue";
import InputError
    from "../../../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton
    from "../../../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Components/PrimaryButton.vue";
import SecondaryButton
    from "../../../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Components/SecondaryButton.vue";

const props = defineProps<{ instruments: { name: string, id: number }[] }>();

const form = useForm({
    firstname: '',
    lastname: '',
    instrument_id: props
        .instruments
        .reduce((previousValue, currentValue) => {
            if (currentValue.id < previousValue.id) {
                return currentValue;
            }
            return previousValue;
        })
        .id,
    part: '0',
});

const part_list = [
    {text: 'n/a', value: 0},
    {text: '1', value: 1},
    {text: '2', value: 2},
    {text: '3', value: 3},
    {text: '4', value: 4},
];


const cancelForm = () => {
};

const submit = () => {
    console.debug(form.data());
    form.post(route('musicians.store'))
};
</script>

<style scoped>

</style>
