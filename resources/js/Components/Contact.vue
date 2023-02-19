<template>
    <div>
        <p :class="{'font-bold' : bold_name}">{{ name }}</p>
        <p v-if="telephon">Telefon: {{ telephon }}</p>
        <p v-if="telefax">Telefax: {{ telefax }}</p>
        <p v-if="mobile">Mobil: {{ mobile }}</p>
        <p>E-Mail:
            <MailtoLink :mail-adress="email">{{ email}}</MailtoLink>
        </p>
    </div>
</template>

<script setup lang="ts">
import {defineProps} from 'vue';
import MailtoLink from "@/Components/Link/MailtoLink.vue";

interface Props {
    name: string,
    email: string,
    telephon?: string,
    telefax?: string,
    mobile?: string,
    bold_name?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    bold_name: false,
});

</script>

<style scoped>

</style>
