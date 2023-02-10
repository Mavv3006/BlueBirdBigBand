<template>
    <div class="relative">
        <div class="absolute w-full">
            <ul class="flex flex-col content-center">
                <MobileNavbarElement container_title="Home" link="/" style="z-index: 1"/>

                <li>
                    <span>Aktuelles</span>
                    <ul>
                        <li>Auftritte</li>
                        <li>
                            <Link href="presse">Presseinfos</Link>
                        </li>
                        <li>
                            <Link href="buchung">Buchungsinsfos</Link>
                        </li>
                    </ul>
                </li>

                <li>
                    <span>Band</span>
                    <ul>
                        <li>
                            <Link href="about-us">Über uns</Link>
                        </li>
                        <li>
                            <Link href="musiker">Musiker</Link>
                        </li>
                        <li>
                            <Link href="anfahrt">Anfahrt</Link>
                        </li>
                    </ul>
                </li>

                <li>
                    <span>Kontakt</span>
                    <ul>
                        <li>
                            <Link href="kontakt">Kontakt</Link>
                        </li>
                        <li>
                            <Link href="impressum">Impressum</Link>
                        </li>
                    </ul>
                </li>

                <li>Login</li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import MobileNavbarElement from "@/Components/Navigation/MobileNavbarElement.vue";</script>


<style scoped>
ul {
    list-style: none;
}
</style>
