<template>
    <div>
        <SubHeading id="austragen">Austragen</SubHeading>

        <p class="mb-6">Es tut uns leid, dass Sie gehen. Geben Sie Ihre E-Mail-Adresse ein, um sich abzumelden.</p>

        <Accordion title="Wie funktioniert der Abmeldeprozess?">
            <div class="bg-gray-50 rounded-lg p-4">
                <ol class="list-decimal list-inside space-y-2 text-gray-600">
                    <li>Geben Sie Ihre E-Mail-Adresse im Formular unten ein</li>
                    <li>Unser Team trägt Sie aus der Newsletter-Liste aus</li>
                </ol>
            </div>
        </Accordion>

        <form @submit.prevent="submitRemovingForm">
            <div>
                <InputLabel for="removingEmail" value="E-Mail Adresse"/>

                <TextInput
                    id="removingEmail"
                    v-model="removingForm.email"
                    class="mt-1 block w-full"
                    required
                    type="email"
                />

                <InputError :message="removingForm.errors.email" class="mt-2"/>
                <InputSuccess v-if="showRemovingSuccess" message="Austragen beantragt." class="mt-2"/>
            </div>


            <div class="flex items-center justify-center mt-4">
                <PrimaryButton :class="{ 'opacity-25': removingForm.processing }"
                               :disabled="removingForm.processing">
                    Austragen
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


const removingForm = useForm<NewsletterRequestType>({
    email: null,
    type: "removing",
    data_privacy_consent: null,
    data_privacy_consent_text: null,
});

let showRemovingSuccess = false;
let submitRemovingForm = () => {
    removingForm.post('/newsletter/request', {
        preserveScroll: true,
        onSuccess: () => {
            showRemovingSuccess = true;
            removingForm.reset('email')
        },
        onStart: () => {
            showRemovingSuccess = false;
        },
    });
}
</script>
