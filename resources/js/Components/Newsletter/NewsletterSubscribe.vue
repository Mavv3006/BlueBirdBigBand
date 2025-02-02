<template>
    <div>
        <SubHeading>{{ title }}</SubHeading>

        <p class="mb-6">Erhalten Sie die neuesten Updates direkt in Ihrem Posteingang.</p>

        <Accordion title="Wie funktioniert der Anmeldeprozess?">
            <div class="bg-gray-50 rounded-lg p-4">
                <ol class="list-decimal list-inside space-y-2 text-gray-600">
                    <li>Geben Sie Ihre E-Mail-Adresse im Formular unten ein</li>
                    <li>Sie erhalten eine Bestätigungs-E-Mail</li>
                    <li>Klicken Sie auf den Verifizierungslink in der E-Mail, um Ihre Adresse zu bestätigen</li>
                    <li>Unser Team fügt Sie der Newsletter-Liste hinzu</li>
                </ol>
            </div>
        </Accordion>

        <form @submit.prevent="submitAddingForm">
            <div>
                <InputLabel for="addingEmail" value="E-Mail Adresse"/>

                <TextInput
                    id="addingEmail"
                    v-model="addingForm.email"
                    class="mt-1 block w-full"
                    required
                    type="email"
                />

                <InputError :message="addingForm.errors.email" class="mt-2"/>
                <InputSuccess v-if="showAddingSuccess" class="mt-2" message="Eintragen beantragt."/>
            </div>

            <div class="flex gap-x-2 flex-row mt-4">
                <input
                    id="data-privacy-consent"
                    class="border-gray-300 focus:border-[#2563EB] focus:ring-[#2563EB] rounded-[5px] shadow-sm disabled:text-gray-500"
                    name="data-privacy-consent" required type="checkbox">
                <InputLabel for="data-privacy-consent">Ich habe die
                    <NavLink href='/datenschutz'>Datenschutzerklärung</NavLink>
                    gelesen und stimme der Verarbeitung meiner Daten gemäß dieser zu. Ich erhalte den Newsletter mit
                    Informationen zu unseren kommenden Auftritten.
                </InputLabel>
            </div>

            <div class="flex items-center justify-center mt-4">
                <PrimaryButton :class="{ 'opacity-25': addingForm.processing }"
                               :disabled="addingForm.processing">
                    Eintragen
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>

<script lang="ts" setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputSuccess from "@/Components/InputSuccess.vue";
import Accordion from "@/Components/Accordion/Accordion.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {NewsletterRequestType} from "@/types/newsletter";
import SubHeading from "@/Components/SubHeading.vue";
import NavLink from "@/Components/Link/NavLink.vue";

defineProps<{
    title: string,
}>()

const addingForm = useForm<NewsletterRequestType>({
    email: null,
    type: "adding",
    data_privacy_consent: false,
    data_privacy_consent_text: "Ich habe die Datenschutzerklärung gelesen und stimme der Verarbeitung meiner Daten gemäß dieser zu. Ich erhalte den Newsletter mit Informationen zu unseren kommenden Auftritten.",
});

let showAddingSuccess = false;

let submitAddingForm = () => {
    console.log('submitting adding form', addingForm.data())
    addingForm.post('/newsletter/request', {
        preserveScroll: true,
        onSuccess: () => {
            showAddingSuccess = true;
            addingForm.reset('email')
        },
        onStart: () => {
            showAddingSuccess = false;
        }
    });
}
</script>

<style scoped>
</style>
