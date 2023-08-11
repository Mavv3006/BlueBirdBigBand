<template>
    <div>
        <FooterHeading>Kontakt</FooterHeading>

        <div class="flex flex-col gap-2 mt-2">
            <FooterLink v-for="link in contactLinks" :href="link.link">
                <font-awesome-icon :icon="['fas', link.icon]"/>
                {{ link.name }}
            </FooterLink>
        </div>
    </div>
</template>

<script setup lang="ts">
import FooterHeading from "@/Components/v2/Footer/FooterHeading.vue";
import FooterLink from "@/Components/v2/Footer/FooterLink.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const contactLinks: { name: string, icon: string, link: string }[] = [
    {name: 'Mausbergweg 144, 67346 Speyer', link: '', icon: 'location-dot'},
    {name: '0171 5808481', link: 'tel:01715808481', icon: 'phone'},
    {name: 'buchung@bluebirdbigband.de', link: 'mailto:buchung@bluebirdbigband.de', icon: 'envelope'},
    {name: 'bandleiter@bluebirdbigband.de', link: 'mailto:bandleiter@bluebirdbigband.de', icon: 'envelope'},
];
</script>

<style scoped>

</style>
