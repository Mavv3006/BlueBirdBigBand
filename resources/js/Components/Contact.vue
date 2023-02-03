<template>
    <div>
    <p>{{ name }}</p>
    <p v-if="telephon">Telefon: {{ telephon }}</p>
    <p v-if="telefax">Telefax: {{ telefax }}</p>
    <p v-if="mobile">Mobil: {{ mobile }}</p>
    <p>E-Mail:
        <NavLink :href="`mailto:${email}`">
            {{ email }}
        </NavLink>
    </p>
    </div>
</template>

<script setup>
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    name: {
        type: String,
        required: true
    },
    email: {
        type: String,
        required: true
    },
    telephon: String,
    telefax: String,
    mobile: String
})

</script>

<style scoped>

</style>
