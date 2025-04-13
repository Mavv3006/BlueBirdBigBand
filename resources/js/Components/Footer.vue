<template>
    <footer class="flex flex-col p-8 text-neutral-600 gap-8 lg:flex-row">
        <div class="flex gap-8 sm:max-w-xl md:mx-auto lg:flex-wrap xl:flex-nowrap">
            <div class="basis-lg lg:basis-md">
                <img alt="Logo der Blue Bird Big Band" class="lg:w-[50%] xl:w-auto" src="/assets/logos/intrologo.gif">
            </div>
            <div>
                <p>
                    Wir sind die Blue Bird Big Band der Städtischen Musikschule Speyer.
                    Aktuell suchen wir noch Musiker/innen, die Posaune spielen.
                </p>
            </div>
        </div>
        <div class="flex px-2 sm:max-w-xl md:min-w-lg md:mx-auto">
            <div class="w-1/3">
                <p class="font-bold text-black pb-1">Navigation</p>
                <ul class="flex flex-col gap-1.5">
                    <li>
                        <a class="border-b-1 border-transparent hover:border-neutral-600 focus:outline-hidden focus:text-text-neutral-600 focus:border-text-neutral-600 transition duration-150 ease-in-out"
                           href="/">
                            Home
                        </a>
                    </li>
                    <li>
                        <a class="border-b-1 border-transparent hover:border-neutral-600 focus:outline-hidden focus:text-text-neutral-600 focus:border-text-neutral-600 transition duration-150 ease-in-out"
                           href="/auftritte">
                            Auftritte
                        </a>
                    </li>
                    <li>
                        <a class="border-b-1 border-transparent hover:border-neutral-600 focus:outline-hidden focus:text-text-neutral-600 focus:border-text-neutral-600 transition duration-150 ease-in-out"
                           href="/musiker">
                            Musiker
                        </a>
                    </li>
                    <li>
                        <a class="border-b-1 border-transparent hover:border-neutral-600 focus:outline-hidden focus:text-text-neutral-600 focus:border-text-neutral-600 transition duration-150 ease-in-out"
                           href="/kontakt">
                            Kontakt
                        </a>
                    </li>
                </ul>
            </div>
            <div class="w-2/3">
                <p class="font-bold text-black pb-1">Kontakt</p>
                <ul class="flex flex-col gap-1.5">
                    <li>
                        <font-awesome-icon class="mr-1" icon="fa-solid fa-location-dot"/>
                        Mausbergweg 144, 67346 Speyer
                    </li>
                    <li>
                        <a class="border-b-1 border-transparent hover:border-neutral-600 focus:outline-hidden focus:text-text-neutral-600 focus:border-text-neutral-600 transition duration-150 ease-in-out"
                           href="tel:01715808481">
                            <font-awesome-icon class="mr-1" icon="fa-solid fa-phone"/>
                            0171 5808481
                        </a>
                    </li>
                    <li>
                        <a class="border-b-1 border-transparent hover:border-neutral-600 focus:outline-hidden focus:text-text-neutral-600 focus:border-text-neutral-600 transition duration-150 ease-in-out"
                           href="mailto:buchung@bluebirdbigband.de">
                            <font-awesome-icon class="mr-1" icon="fa-solid fa-envelope"/>
                            buchung@bluebirdbigband.de
                        </a>
                    </li>
                    <li>
                        <a class="border-b-1 border-transparent hover:border-neutral-600 focus:outline-hidden focus:text-text-neutral-600 focus:border-text-neutral-600 transition duration-150 ease-in-out"
                           href="mailto:bandleiter@bluebirdbigband.de">
                            <font-awesome-icon class="mr-1" icon="fa-solid fa-envelope"/>
                            bandleiter@bluebirdbigband.de
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</template>

<script lang="ts" setup>

import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
</script>

<style scoped>

</style>
