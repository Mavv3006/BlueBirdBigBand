<template>
    <public-layout>
        <Heading> Newsletter</Heading>

        <div>
            Hier können Sie sich für unseren Konzert-Newsletter eintragen bzw. austragen.
        </div>

        <div class="grid mt-4 md:grid-cols-2 gap-y-12 md:gap-x-14">
            <section>
                <SubHeading>Eintragen</SubHeading>

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
import {useForm} from "@inertiajs/vue3";
import Heading from "@/Components/Heading.vue";
import SubHeading from "@/Components/SubHeading.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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

let submitAddingForm = () => {
    console.log('submitting adding form', addingForm.data())
    addingForm.post('/newsletter/request', {
        onSuccess: () => addingForm.reset('email')
    });
}
let submitRemovingForm = () => {
    console.log('submitting adding form', removingForm.data())
    removingForm.post('/newsletter/request', {
        onSuccess: () => removingForm.reset('email')
    });
}

</script>

<style scoped>

</style>
