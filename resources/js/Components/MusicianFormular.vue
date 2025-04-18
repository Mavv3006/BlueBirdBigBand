<template>
    <div>
        <form @submit.prevent="submit">
            <div class="grid grid-rows-2 gap-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-16 w-full">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-16 w-full">
                    <div>
                        <InputLabel for="instrument" value="Instrument"/>
                        <select
                            id="instrument"
                            v-model="form.instrument_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs"
                            name="instrument"
                            required>
                            <option
                                v-for="instrument in instruments"
                                :disabled="instrument.id === 0"
                                :value="instrument.id"
                            >
                                {{ instrument.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.instrument_id" class="mt-2"/>
                    </div>

                    <div>
                        <div v-if="hasPicture">
                            <div class="font-medium text-sm">Bild</div>
                            <div class="flex gap-2">
                                <MusicianPicture
                                    :alt="`Bild von Musiker ${musician.firstname} ${musician.lastname}`"
                                    :src="`/storage/${musician.picture_filepath}`"
                                />
                                <div class="flex flex-col justify-center gap-2">
                                    <Button @click="deletePicture">Bild löschen</Button>
                                </div>
                            </div>
                        </div>

                        <div v-else>
                            <InputLabel for="picture" value="Bild"/>
                            <input name="picture" type="file" @input="form.picture = $event.target.files[0]"/>
                            <InputError :message="form.errors.picture" class="mt-2"/>
                        </div>

                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-16 w-full">
                    <div class="flex gap-4">
                        <input
                            type="checkbox"
                            name="isActive" v-model="form.isActive"
                            class="rounded
                               dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm
                               focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"/>
                        <InputLabel for="isActive" value="Aktiv?"/>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center mt-4 gap-8">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Speichern
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>

<script lang="ts" setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import MusicianPicture from "@/Components/MusicianPicture.vue";

const deletingPicture = ref(false);

const props = defineProps<{
    method: string,
    submit_url: string,
    instruments: { name: string, id: number }[],
    musician?: {
        id: number,
        firstname: string,
        lastname: string,
        instrument_id: number,
        picture_filepath?: string,
        isActive: boolean
    }
}>();

const form = useForm({
    _method: props.method,
    firstname: props.musician === undefined ? '' : props.musician.firstname,
    lastname: props.musician === undefined ? '' : props.musician.lastname,
    instrument_id: props.musician === undefined ? props
        .instruments
        .reduce((previousValue, currentValue) => {
            if (currentValue.id < previousValue.id) {
                return currentValue;
            }
            return previousValue
        })
        .id : props.musician.instrument_id,
    picture: null,
    isActive: props.musician === undefined ? true : props.musician.isActive
});

const submit = () => {
    if (deletingPicture.value) return;
    form.post(props.submit_url, {onStart: console.debug})
}

const deletePicture = () => {
    useForm({_method: 'delete'}).post(
        `/admin/musicians/${props.musician.id}/picture`,
        {
            onStart: () => {
                deletingPicture.value = true;
            },
            onFinish: () => {
                deletingPicture.value = false;
            }
        }
    );
}

const hasPicture = computed<boolean>(() => {
    if (props.musician === undefined) return false;
    if (props.musician.picture_filepath === undefined) return false;
    return props.musician.picture_filepath !== null;
});
</script>

<style scoped>
@reference "tailwindcss";
img {
    @apply h-36;
    max-width: 100%;
}
</style>
