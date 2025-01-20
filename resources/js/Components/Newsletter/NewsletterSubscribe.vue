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
                <InputSuccess v-if="showAddingSuccess" message="Eintragen beantragt." class="mt-2"/>
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

<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputSuccess from "@/Components/InputSuccess.vue";
import Accordion from "@/Components/Accordion/Accordion.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import {NewsletterRequestType} from "@/types/newsletter";
import SubHeading from "@/Components/SubHeading.vue";

defineProps<{
    title: string,
}>()

const addingForm = useForm<NewsletterRequestType>({
    email: null,
    type: "adding"
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
