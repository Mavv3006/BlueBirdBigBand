<template>
    <public-layout>
        <Heading>Wegbeschreibung zur Probe</Heading>

        <div class="flex flex-col gap-8">
            <p>
                Probe ist jeden Mittwoch - außer in den Schulferien (
                <NavLink href="https://www.schulferien.org/Rheinland-Pfalz/rheinland-pfalz.html"> Ferientermine
                    Rheinland-Pfalz
                </NavLink>
                ) - im Unterrichtsraum 115 im 1. OG der Musikschule der Stadt Speyer. Die <span class="font-bold">Einsteiger-Dometown-Big Band</span>
                probt von 18:15 bis 20:00 Uhr, die <span class="font-bold">BlueBirdBigBand</span> von 20:15 bis 22:00
                Uhr.
            </p>

            <div>
                <p class="font-bold underline">Die Adresse lautet:</p>
                <p>Musikschule der Stadt Speyer</p>
                <p>Mausbergweg 144</p>
                <p>67346 Speyer</p>
            </div>
        </div>
    </public-layout>
</template>

<script setup lang="ts">
import Heading from "@/Components/Heading.vue";
import PublicLayout from "@/Layouts/PublicLayout.vue";
import NavLink from "@/Components/Link/NavLink.vue";
</script>

<style scoped>
p {
    @apply text-justify
}
</style>
