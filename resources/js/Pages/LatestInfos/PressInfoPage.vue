<template>
    <public-layout>
        <Head>
            <title>Pressestimmen</title>
            <meta content="Your page description" name="description">
        </Head>

        <Heading>Presseinfos</Heading>

        <div class="mb-3 flex justify-between">
            <div class="flex flex-col justify-evenly">
                <div>
                    <h1 class="font-bold text-xl">Blue Bird Big Band</h1>
                    <p>der Städtischen Musikschule Speyer</p>
                </div>

                <h2 class="font-bold text-lg">Let's swing again!</h2>
                <h2 class="font-bold text-lg">Bigband-Jazz vom Feinsten</h2>
            </div>

            <img alt="Blue Bird Big Band Vogel" src="assets/logos/logo-bird.gif"/>
        </div>

        <p class="mb-3 text-justify">
            Die Idee, unter dem Dach der Städtischen Musikschule Speyer eine Big-Band zu gründen, reifte im Jahr 1992.
        </p>

        <p class="mb-3 text-justify">
            Die Überlegungen trugen schnell Früchte und unter der Leitung von Klaus Gehrlein begannen die Proben. Heute,
            im 29. Jahr ihres Bestehens, treffen sich rund 25 Musikerinnen und Musiker zu den wöchentlichen Proben der
            Blue Bird Big Band. Alle Altersstufen sind vertreten; die Jüngsten sind 18, die Ältesten über 80 Jahre alt.
        </p>

        <p class="mb-3 text-justify">
            Die Musikerinnen und Musiker sind geprägt vom Spaß an der Musik, besonders vom Bigband-Jazz. Ständig
            arbeitet die Band daran, möglichst professionell zu klingen. Knackige Saxophone, sonore Posaunen, strahlende
            Trompeten und eine swingende Rhythmusgruppe zeichnen den Sound aus. Einige gute Solisten unterstreichen den
            hohen Anspruch.
        </p>

        <p class="mb-3 text-justify">
            Das Repertoire reicht von Duke Ellingtons Swing der vierziger Jahre, über Charlie Parker bis hin zu
            Arrangements zeitgenössischer Komponisten. Liebhaber des Swing kommen ebenso auf ihre Kosten, wie Latin- und
            Funk-Fans.
        </p>

        <p class="mb-3 text-justify">
            Die Band ist ein gern gesehener musikalischer Gast und viel unterwegs. Sie hat ihre Fangemeinde ständig
            vergrößert und tritt bei den verschiedensten Gelegenheiten auf, um Swing, Jazz und gute Laune zu verbreiten.
            Jazz liegt im Trend, besonders Bigband-Jazz.
        </p>

        <p class="mb-3 text-justify">
            Die Band ist unter
            <NavLink href="https://www.bluebirdbigband.de">www.bluebirdbigband.de</NavLink>
            im Internet zu finden. Dort gibt es Informationen über Termine, die Band, die Musiker, das Repertoire und
            vieles mehr.
        </p>

        <div class="flex flex-col mb-3 md:flex-row md:mb-2 md:gap-3 lg:gap-5 xl:gap-7 2xl:gap-9">
            <p class="font-bold mb-1 md:mb-0 lg:w-1/2 lg:text-right">Kontaktadresse der Blue Bird Big Band</p>
            <div class="flex gap-2 flex-wrap justify-between md:flex-col md:flex-nowrap lg:w-1/2">
                <div>
                    <p>Klaus Gehrlein</p>
                    <p>Alte Ziegelei 23</p>
                    <p>67346 Speyer</p>
                </div>
                <div>
                    <p>Mobil: 0171 5808481</p>
                    <p> E-Mail:
                        <MailtoLink mail-adress="bandleiter@bluebirdbigband.de">
                            bandleiter@bluebirdbigband.de
                        </MailtoLink>
                    </p>
                </div>
            </div>
        </div>
    </public-layout>
</template>

<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import NavLink from "@/Components/Link/NavLink.vue";
import MailtoLink from "@/Components/Link/MailtoLink.vue";
import {Head} from '@inertiajs/vue3';</script>
