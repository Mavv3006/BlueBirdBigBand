<template>
    <PublicLayout>
        <Heading>E-Mail Verteiler</Heading>

        <div v-for="group in emails" class="email-group">
            <EmailGroup :emails="group.emails" :name="group.name"/>
        </div>
    </PublicLayout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import EmailGroup, {EmailGroupModel} from "@/Components/EmailGroup.vue";

const emails: EmailGroupModel[] = [
    {
        name: 'ALLE (Midi / Maxi)',
        emails: [
            {name: 'Alle (Midi/Maxi)', email: 'MusikerInnen@BlueBirdBigBand.de'},
        ],
    },
    {
        name: 'MAXI',
        emails: [
            {
                name: 'Alle Maxi-Mitglieder',
                email: 'maxi@BlueBirdBigBand.de',
            },
            {
                name: 'Saxophonsatz',
                email: 'maxi-Saxophone@BlueBirdBigBand.de',
            },
            {
                name: 'Posaunensatz',
                email: 'maxi-Posaunen@BlueBirdBigBand.de',
            },
            {
                name: 'Trompetensatz',
                email: 'maxi-Trompeten@BlueBirdBigBand.de',
            },
            {
                name: 'Rhythmusgruppe',
                email: 'maxi-Rhythmusgruppe@BlueBirdBigBand.de',
            },
        ],
    },
    {
        name: 'MIDI',
        emails: [
            {
                name: 'Alle Midi-Mitglieder',
                email: 'midi@BlueBirdBigBand.de',
            },
            {
                name: 'Saxophonsatz',
                email: 'midi-Saxophone@BlueBirdBigBand.de',
            },
            {
                name: 'Posaunensatz',
                email: 'midi-Posaunen@BlueBirdBigBand.de',
            },
            {
                name: 'Trompetensatz',
                email: 'midi-Trompeten@BlueBirdBigBand.de',
            },
            {
                name: 'Rhythmusgruppe',
                email: 'midi-Rhythmusgruppe@BlueBirdBigBand.de',
            },
        ],
    },
    {
        name: 'SONSTIGE',
        emails: [
            {
                name: 'Bandleader',
                email: 'bandleiter@BlueBirdBigBand.de',
            },
            {
                name: 'Webmaster',
                email: 'webadmin@bluebirdbigband.de',
            },
        ],
    },
];
</script>

<style scoped>
.email-group:not(:last-child) {
    border-bottom: 1px solid lightgray;
    padding-bottom: 1.5em;
}
</style>
