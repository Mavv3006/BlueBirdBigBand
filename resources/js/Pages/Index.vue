<template>
    <public-layout>

        <Head title="Willkommen"/>

        <h1 class="text-center font-bold text-[#3d4449] text-xl md:text-3xl lg:text-4xl xl:text-5xl">
            Willkommen bei der
            <br>
            Blue Bird Big Band
            <br>
            der Städtischen Musikschule Speyer
        </h1>

        <img alt="Gruppenbild der Blue Bird Big Band" class="w-[80%] block mx-auto my-4"
             src="assets/grouppictures/group-picture.jpg">

        <div class="scroll overflow-hidden relative z-0">
            <span class="absolute w-max text-lg h-full m-0 text-left text-[#990000] font-bold w-[100vw] tracking-[2px]">
                +++ Schlagzeuger/in und Posaunist/innen gesucht +++
            </span>
        </div>
    </public-layout>
</template>

<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import {Head} from '@inertiajs/vue3';</script>

<style scoped>
.scroll {
    --height: calc(50px - 1em);
    height: var(--height);
}

.scroll span {
    line-height: var(--height);
    animation: scroll-left 14.5s linear infinite;
}

@keyframes scroll-left {
    0% {
        transform: translateX(calc(85vw - 2em + 5px));
    }
    100% {
        transform: translateX(calc(-267px - 5px));
    }
}

@media (min-width: 640px) {
    .scroll span {
        animation-duration: 16s;
    }
}

@media (min-width: 768px) {
    .scroll span {
        animation-duration: 18s;
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(calc(88vw - 2em + 5px));
        }
        100% {
            transform: translateX(calc(-267px - 5px));
        }
    }
}

@media (min-width: 1024px) {
    .scroll span {
        animation-duration: 20s;
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(calc(85vw - 2em + 5px));
        }
        100% {
            transform: translateX(calc(-267px - 5px));
        }
    }
}

@media (min-width: 1280px) {
    .scroll span {
        animation-duration: 22s;
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(calc(80vw - 2em + 5px));
        }
        100% {
            transform: translateX(calc(-267px - 5px));
        }
    }
}


@media (min-width: 1536px) {
    .scroll span {
        animation-duration: 24s;
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(calc(75vw - 2em + 5px));
        }
        100% {
            transform: translateX(calc(-267px - 5px));
        }
    }
}

</style>
