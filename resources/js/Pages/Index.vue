<template>
    <public-layout>
        <h1 class="text-center text-xl md:text-3xl lg:text-4xl xl:text-5xl">
            Willkommen bei der
            <br>
            Blue Bird Big Band
            <br>
            der Städtischen Musikschule Speyer
        </h1>

        <img alt="Gruppenbild der Blue Bird Big Band" class="w-[80%] block mx-auto my-2"
             src="assets/grouppictures/group-picture.jpg">

        <div class="scroll overflow-hidden relative">
            <span class="absolute h-full m-0 text-left text-red-700 font-bold w-[100vw] tracking-[2px]">+++ Musiker/in gesucht +++</span>
        </div>
    </public-layout>
</template>

<script lang="ts" setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";</script>

<style scoped>
.scroll {
    --height: calc(50px - 1em);
    height: var(--height);
}

.scroll span {
    line-height: var(--height);
    animation: scroll-left 12.5s linear infinite;
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
        animation-duration: 14s;
    }
}

@media (min-width: 768px) {
    .scroll span {
        animation-duration: 16s;
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
        animation-duration: 18s;
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
        animation-duration: 20s;
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
        animation-duration: 22s;
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
