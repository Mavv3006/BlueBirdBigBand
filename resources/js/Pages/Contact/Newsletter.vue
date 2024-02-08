<template>
    <public-layout>
        <Head title="Newsletter"></Head>

        <Heading> Newsletter</Heading>

        <div>
            Hier können Sie sich für unseren Konzert-Newsletter eintragen bzw. austragen.
        </div>

        <div class="grid md:grid-cols-2 gap-y-12 md:gap-x-14">
            <section>
                <SubHeading>Eintragen</SubHeading>

                <form action="">
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

                <form action="">
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
import {Head, useForm} from "@inertiajs/vue3";
import Heading from "@/Components/Heading.vue";
import SubHeading from "@/Components/SubHeading.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const addingForm = useForm<{
    email: string,
}>({
    email: null,
});

const removingForm = useForm<{
    email: string,
}>({
    email: null,
});


</script>

<style scoped>

</style>
