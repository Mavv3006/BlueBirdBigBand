<template>
    <public-layout>
        <Head title="Newsletter"></Head>

        <Heading> Newsletter</Heading>

        <div>
            Hier können Sie sich für unseren Konzert-Newsletter eintragen bzw. austragen.
        </div>

        <div class="grid mt-4 md:grid-cols-2 gap-y-12 md:gap-x-14">
            <section>
                <SubHeading>Eintragen</SubHeading>

                <p class="mb-6">Erhalten Sie die neuesten Updates direkt in Ihrem Posteingang.</p>

                <Accordion title="Wie funktioniert der Anmeldeprozess?">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <ol class="list-decimal list-inside space-y-2 text-gray-600">
                            <li>Geben Sie Ihre E-Mail-Adresse im Formular unten ein</li>
                            <li>Sie erhalten eine Bestätigungs-E-Mail</li>
                            <li>Klicken Sie auf den Verifizierungslink in der E-Mail, um Ihre Adresse zu bestätigen</li>
                            <li>Unser Team prüft und fügt Sie der Newsletter-Liste hinzu</li>
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
                        <InputSuccesss v-if="showAddingSuccess" message="Eintragen beantragt." class="mt-2"/>
                    </div>


                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton :class="{ 'opacity-25': addingForm.processing }"
                                       :disabled="addingForm.processing">
                            Eintragen
                        </PrimaryButton>
                    </div>
                </form>
            </section>

            <section>
                <SubHeading>Austragen</SubHeading>

                <p class="mb-6">Es tut uns leid, dass Sie gehen. Geben Sie Ihre E-Mail-Adresse ein, um sich abzumelden.</p>

                <Accordion title="Wie funktioniert der Abmeldeprozess?">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <ol class="list-decimal list-inside space-y-2 text-gray-600">
                            <li>Geben Sie Ihre E-Mail-Adresse im Formular unten ein</li>
                            <li>Sie werden sofort vom Newsletter abgemeldet</li>
                            <li>Sie erhalten eine Bestätigungs-E-Mail über Ihre Abmeldung</li>
                            <li>Sie können sich jederzeit wieder anmelden</li>
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
                        <InputSuccesss v-if="showRemovingSuccess" message="Austragen beantragt." class="mt-2"/>
                    </div>


                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton :class="{ 'opacity-25': removingForm.processing }"
                                       :disabled="removingForm.processing">
                            Austragen
                        </PrimaryButton>
                    </div>
                </form>
            </section>
        </div>
    </public-layout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Heading from "@/Components/Heading.vue";
import SubHeading from "@/Components/SubHeading.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputSuccesss from "@/Components/InputSuccesss.vue";
import Accordion from "@/Components/Accordion/Accordion.vue";

type NewsletterRequestType = {
    email: string,
    type: 'adding' | 'removing';
};

const addingForm = useForm<NewsletterRequestType>({
    email: null,
    type: "adding"
});

const removingForm = useForm<NewsletterRequestType>({
    email: null,
    type: "removing"
});

let showAddingSuccess = false;
let showRemovingSuccess = false;

let submitAddingForm = () => {
    console.log('submitting adding form', addingForm.data())
    addingForm.post('/newsletter/request', {
        onSuccess: () => {
            showAddingSuccess = true;
            addingForm.reset('email')
        },
        onStart: () => {
            showAddingSuccess = false;
        }
    });
}
let submitRemovingForm = () => {
    console.log('submitting adding form', removingForm.data())
    removingForm.post('/newsletter/request', {
        onSuccess: () => {
            showRemovingSuccess = true;
            removingForm.reset('email')
        },
        onStart: () => {
            showRemovingSuccess = false;
        }
    });
}

</script>

<style scoped>

</style>
