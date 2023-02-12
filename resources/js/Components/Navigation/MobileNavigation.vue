<template>
    <div class="relative">
        <div class="absolute w-full">
            <ul class="flex flex-col content-center">
                <MobileNavbarElement
                    container_title="Home"
                    link="/"
                    style="z-index: 1"
                    v-model:is_open="homeIsOpen"
                />

                <MobileNavbarElement
                    v-model:is_open="latestInfoIsOpen"
                    container_title="Aktuelles"
                    style="z-index: 2"
                >
                    <Link href="auftritte">Auftritte</Link>
                    <Link href="presse">Presseinfos</Link>
                    <Link href="buchung">Buchungsinfos</Link>
                </MobileNavbarElement>

                <MobileNavbarElement
                    v-model:is_open="bandIsOpen"
                    container_title="Band"
                    style="z-index: 3"
                >
                    <Link href="about-us">Über uns</Link>
                    <Link href="musiker">Musiker</Link>
                    <Link href="anfahrt">Anfahrt</Link>
                </MobileNavbarElement>

                <MobileNavbarElement
                    v-model:is_open="contactIsOpen"
                    container_title="Kontakt"
                    style="z-index: 4"
                >
                    <Link href="kontakt">Kontakt</Link>
                    <Link href="impressum">Impressum</Link>
                </MobileNavbarElement>

                <MobileNavbarElement
                    v-model:is_open="loginIsOpen"
                    container_title="Login"
                    link="/"
                    style="z-index: 6"
                />
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import MobileNavbarElement from "@/Components/Navigation/MobileNavbarElement.vue";
import {ref} from "vue";

const homeIsOpen = ref<boolean>(false);
const latestInfoIsOpen = ref<boolean>(false);
const bandIsOpen = ref<boolean>(false);
const contactIsOpen = ref<boolean>(false);
const loginIsOpen = ref<boolean>(false);
</script>

<style scoped>
ul {
    list-style: none;
}
</style>
