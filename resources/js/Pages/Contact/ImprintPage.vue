<template>
    <public-layout>
        <Head title="Impressum"/>

        <Heading>Impressum</Heading>

        <section>
            <h2>Diensteanbieter</h2>
            <div>
                <p>Klaus Gehrlein</p>
                <p>Alte Ziegelei 23</p>
                <p>67346 Speyer</p>
            </div>
        </section>

        <section>
            <h2>Kontaktmöglichkeiten</h2>
            <div>
                <p>
                    E-Mail-Adresse:
                    <MailtoLink mail-adress="bandleiter@bluebirdbigband.de">bandleiter@bluebirdbigband.de</MailtoLink>
                </p>
                <p>Telefon: 0171 5808481</p>
            </div>
        </section>

        <section>
            <h2>Haftungs- und Schutzrechtshinweise</h2>
            <div>
                <p>
                    Haftungsausschluss: Die Inhalte dieses Onlineangebotes wurden sorgfältig und nach unserem aktuellen
                    Kenntnisstand erstellt, dienen jedoch nur der Information und entfalten keine rechtlich bindende
                    Wirkung,
                    sofern es sich nicht um gesetzlich verpflichtende Informationen (z.B. das Impressum, die
                    Datenschutzerklärung, AGB oder verpflichtende Belehrungen von Verbrauchern) handelt. Wir behalten
                    uns
                    vor,
                    die Inhalte vollständig oder teilweise zu ändern oder zu löschen, soweit vertragliche
                    Verpflichtungen
                    unberührt bleiben. Alle Angebote sind freibleibend und unverbindlich.
                </p>
                <p>
                    Links auf fremde Webseiten: Die Inhalte fremder Webseiten, auf die wir direkt oder indirekt
                    verweisen,
                    liegen
                    außerhalb unseres Verantwortungsbereiches und wir machen sie uns nicht zu Eigen. Für alle Inhalte
                    und
                    Nachteile, die aus der Nutzung der in den verlinkten Webseiten aufrufbaren Informationen entstehen,
                    übernehmen wir keine Verantwortung.
                </p>
                <p>
                    Urheberrechte und Markenrechte: Alle auf dieser Website dargestellten Inhalte, wie Texte,
                    Fotografien,
                    Grafiken, Marken und Warenzeichen sind durch die jeweiligen Schutzrechte (Urheberrechte,
                    Markenrechte)
                    geschützt. Die Verwendung, Vervielfältigung usw. unterliegen unseren Rechten oder den Rechten der
                    jeweiligen
                    Urheber bzw. Rechteinhaber.
                </p>

                <p>
                    <a href="https://datenschutz-generator.de/"
                       rel="noopener noreferrer nofollow"
                       target="_blank"
                       title="Rechtstext von Dr. Schwenke - für weitere Informationen bitte anklicken.">
                        Erstellt mit kostenlosem Datenschutz-Generator.de von Dr. Thomas Schwenke
                    </a>
                </p>
            </div>
        </section>
    </public-layout>
</template>

<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from '@inertiajs/vue3';
import MailtoLink from "@/Components/Link/MailtoLink.vue";
</script>


<style scoped>
@reference "tailwindcss";
h2 {
    font-weight: bold;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

section:not(:last-of-type) {
    margin-bottom: 2rem;
}

section > div:has(p) {
    display: flex;
    gap: 1rem;
    flex-direction: column;
}


a {
    @apply border-b-2 border-transparent text-blue-900 hover:border-blue-900 focus:outline-hidden focus:text-blue-900 focus:border-blue-900 transition duration-150 ease-in-out;
}
</style>
