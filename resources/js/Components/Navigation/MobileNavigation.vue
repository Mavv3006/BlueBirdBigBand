<template>
    <div class="relative font-semibold shadow-lg">
        <div class="absolute w-full">
            <ul class="flex flex-col content-center">
                <MobileNavbarElement
                    container_title="Home"
                    link="/"
                    z-index="1"
                    v-model:is_open="homeIsOpen"
                />

                <MobileNavbarElement
                    v-model:is_open="latestInfoIsOpen"
                    container_title="Aktuelles"
                    z-index="2"
                >
                    <p class="p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white submenu-element">
                        <Link href="auftritte">Auftritte</Link>
                    </p>
                    <p class="p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white">
                        <Link href="presse">Presseinfos</Link>
                    </p>
                    <p class="p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white">
                        <Link href="buchung">Buchungsinfos</Link>
                    </p>
                </MobileNavbarElement>

                <MobileNavbarElement
                    v-model:is_open="bandIsOpen"
                    container_title="Band"
                    z-index="3"
                >
                    <p class="p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white">
                        <Link href="about-us">Über uns</Link>
                    </p>
                    <p class="p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white">
                        <Link href="musiker">Musiker</Link>
                    </p>
                    <p class="p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white">
                        <Link href="anfahrt">Anfahrt</Link>
                    </p>
                </MobileNavbarElement>

                <MobileNavbarElement
                    v-model:is_open="contactIsOpen"
                    container_title="Kontakt"
                    z-index="4"
                >
                    <p class="p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white">
                        <Link href="kontakt">Kontakt</Link>
                    </p>
                    <p class="p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white">
                        <Link href="impressum">Impressum</Link>
                    </p>
                </MobileNavbarElement>

                <MobileNavbarElement
                    v-model:is_open="loginIsOpen"
                    container_title="Login"
                    link="/"
                    z-index="6"
                />
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import MobileNavbarElement from "@/Components/Navigation/MobileNavbarElement.vue";
import {ref} from "vue";

const props = defineProps<{ isOpen: boolean }>();
const emits = defineEmits<{
    (e: 'update:isOpen', isOpen: boolean): void
}>();

const localIsOpen = ref<boolean>(props.isOpen);
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

.submenu-element {
    @apply p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white;
}
</style>
