<template>
    <public-layout>
        <Heading>Presseinfos</Heading>

        <div>
            <div>
                <div>
                    <h1>Blue Bird Big Band</h1>
                    <p>der Städtischen Musikschule Speyer</p>
                </div>

                <h2>Let's swing again!</h2>
                <h2>Bigband-Jazz vom Feinsten</h2>
            </div>

            <div>
                <!-- TODO: Add link to picture -->
                <img src="" alt="Blue Bird Big Band Vogel"/>
            </div>
        </div>

        <p>
            Die Idee, unter dem Dach der Städtischen Musikschule Speyer eine Big-Band zu gründen, reifte im Jahr 1992.
        </p>

        <p>
            Die Überlegungen trugen schnell Früchte und unter der Leitung von Klaus Gehrlein begannen die Proben. Heute,
            im 29. Jahr ihres Bestehens, treffen sich rund 25 Musikerinnen und Musiker zu den wöchentlichen Proben der
            Blue Bird Big Band. Alle Altersstufen sind vertreten; die Jüngsten sind 18, die Ältesten über 80 Jahre alt.
        </p>

        <p>
            Die Musikerinnen und Musiker sind geprägt vom Spaß an der Musik, besonders vom Bigband-Jazz. Ständig
            arbeitet die Band daran, möglichst professionell zu klingen. Knackige Saxophone, sonore Posaunen, strahlende
            Trompeten und eine swingende Rhythmusgruppe zeichnen den Sound aus. Einige gute Solisten unterstreichen den
            hohen Anspruch.
        </p>

        <p>
            Das Repertoire reicht von Duke Ellingtons Swing der vierziger Jahre, über Charlie Parker bis hin zu
            Arrangements zeitgenössischer Komponisten. Liebhaber des Swing kommen ebenso auf ihre Kosten, wie Latin- und
            Funk-Fans.
        </p>

        <p>
            Die Band ist ein gern gesehener musikalischer Gast und viel unterwegs. Sie hat ihre Fangemeinde ständig
            vergrößert und tritt bei den verschiedensten Gelegenheiten auf, um Swing, Jazz und gute Laune zu verbreiten.
            Jazz liegt im Trend, besonders Bigband-Jazz.
        </p>

        <p>
            Die Band ist unter
            <NavLink href="https://www.bluebirdbigband.de">www.bluebirdbigband.de</NavLink>
            im Internet zu finden. Dort gibt es Informationen über Termine, die Band, die Musiker, das Repertoire und
            vieles mehr.
        </p>
    </public-layout>
</template>

<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import NavLink from "@/Components/NavLink.vue";</script>

<style scoped>

</style>
