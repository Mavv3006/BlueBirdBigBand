<template>
    <div>
        <form @submit.prevent="submit" class="gap-4 flex flex-col">
            <p>
                Es können nur Konzerte bearbeitet werden, die in der Zukunft liegen. Vergangene Konzerte
                können nicht mehr aktualisiert werden.
            </p>

            <div class="grid-container sm:grid-cols-2 md:grid-cols-3">
                <div class="sm:col-span-2 md:col-span-1">
                    <InputLabel for="date">Datum</InputLabel>
                    <TextInput disabled required class="w-full" type="date" name="date" id="date" v-model="form.date"/>
                </div>
                <div>
                    <InputLabel for="start_time">Startzeit</InputLabel>
                    <TextInput required class="w-full" type="time" step="1" name="start_time" id="start_time"
                               v-model="form.times.start"/>
                </div>
                <div>
                    <InputLabel for="end_time">Endzeit</InputLabel>
                    <TextInput required class="w-full" type="time" step="1" name="end_time" id="end_time"
                               v-model="form.times.end"/>
                </div>
            </div>

            <div class="grid-container lg:grid-cols-2">
                <div>
                    <InputLabel for="description_event">Event Beschreibung</InputLabel>
                    <TextInput required class="w-full" type="text" name="description_event"
                               v-model="form.description.event"
                               id="description_event"/>
                </div>
                <div>
                    <InputLabel for="description_venue">Ort Beschreibung</InputLabel>
                    <TextInput required class="w-full" type="text" name="description_venue"
                               v-model="form.description.venue"
                               id="description_venue"/>
                </div>
            </div>

            <div>
                <InputLabel>Welche Band spielt?</InputLabel>
                <select
                    name="band"
                    v-model="form.band_id"
                    id="band"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    required
                >
                    <option
                        v-for="band in custom_bands"
                        :value="band.id"
                        :disabled="band.id === 0"
                    >
                        {{ band.name }}
                    </option>
                </select>
            </div>

            <div class="grid-container sm:grid-cols-3">
                <div class="sm:col-span-2">
                    <InputLabel for="street">Straße</InputLabel>
                    <TextInput required class="w-full" type="text" name="street" id="street"
                               v-model="form.venue.street"/>
                </div>
                <div>
                    <InputLabel for="house_number">Hausnummer</InputLabel>
                    <TextInput required class="w-full" type="text" name="house_number" id="house_number"
                               v-model="form.venue.house_number"/>
                </div>
            </div>

            <div>
                <div class="flex gap-4">
                    <input
                        type="checkbox"
                        name="create_new_venue"
                        class="rounded
                               dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm
                               focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                        id="create_new_venue"
                        v-model="form.venue.create_new_venue"/>
                    <InputLabel for="create_new_venue">Neuen Ort anlegen?</InputLabel>
                </div>
            </div>

            <div>
                <div>
                    <div v-if="!form.venue.create_new_venue">
                        <InputLabel for="available_venues">Ort auswählen</InputLabel>
                        <select
                            name="available_venues"
                            id="available_venues"
                            :disabled="form.venue.create_new_venue"
                            v-model="form.venue.selected_plz"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option
                                v-for="venue in custom_venues"
                                :value="venue.plz"
                                :disabled="venue.plz=== 0"
                            >
                                {{ venue.plz === 0 ? venue.name : `${venue.plz} - ${venue.name}` }}
                            </option>
                        </select></div>
                </div>

                <div class="grid-container sm:grid-cols-3" v-if="form.venue.create_new_venue">
                    <div>
                        <InputLabel for="venue_plz">PLZ</InputLabel>
                        <TextInput :disabled="!form.venue.create_new_venue" required class="w-full" type="number"
                                   name="venue_plz" id="venue_plz"
                                   v-model="form.venue.new_plz"/>
                    </div>
                    <div class="sm:col-span-2">
                        <InputLabel for="venue_name">Ort</InputLabel>
                        <TextInput :disabled="!form.venue.create_new_venue" required class="w-full" type="text"
                                   name="venue_name" id="venue_name"
                                   v-model="form.venue.new_name"/>
                    </div>
                </div>
            </div>

            <div v-if="form.hasErrors" class="mt-4">
                <div class="text-xl">Errors</div>
                <div>
                    <p v-for="error in form.errors">- {{ error }}</p>
                </div>
            </div>

            <div class="flex justify-center">
                <PrimaryButton>Speichern</PrimaryButton>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import {Band, Concert, Venue} from "@/types/concert";
import {onMounted} from "vue";

const props = defineProps<{
    venues: Venue[],
    bands: Band[],
    concert: Concert
}>();

const custom_bands: Band[] = [
    {id: 0, name: '--- bitte wählen ---'},
    ...props.bands
];

const custom_venues: Venue[] = [
    {plz: 0, name: '--- bitte wählen ---'},
    ...props.venues
];

const current_band: number = custom_bands.filter((value) => value.name === props.concert.band)[0].id;

const form = useForm({
    date: props.concert.date,
    band_id: current_band,
    times: {
        start: props.concert.start_time,
        end: props.concert.end_time
    },
    venue: {
        new_plz: 0,
        new_name: '',
        street: props.concert.address.street,
        house_number: props.concert.address.number,
        create_new_venue: false,
        selected_plz: props.concert.address.plz,
    },
    description: {
        event: props.concert.description.event,
        venue: props.concert.description.venue,
    }
});

const submit = () => form.submit(
    'put',
    `/admin/concerts/${props.concert.id}`,
    {
        onStart: console.debug,
        onError: console.error
    }
);

onMounted(() => {
    console.debug({
        bands: props.bands,
        concert: props.concert,
        venues: props.venues
    });
})
</script>

<style scoped>
.grid-container {
    @apply grid gap-y-4 gap-x-4 md:gap-x-8;
}
</style>
