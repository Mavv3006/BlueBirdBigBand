<template>
    <ul class="text-white mt-3 gap-9 justify-center content-center">
        <li>Home</li>
        <li class="nav-container ">Aktuelles</li>
        <li class="nav-container ">Band</li>
        <li class="nav-container ">Kontakt</li>
        <li class="">Login</li>
    </ul>
</template>

<script setup>
/*
* Info about dropdown:
* https://www.w3schools.com/Css/css_dropdowns.asp
* https://codyhouse.co/demo/mega-dropdown/index.html
* https://codyhouse.co/ds/components/app/language-picker
* */
</script>

<style scoped>
.nav-container {
    @apply pr-7;
}
.nav-container:after {
    content: "";
    position: absolute;
    display: block;
    top: 50%;
    right: 13px;
    width: 0;
    height: 0;
    border-top: 4px solid #d61000;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    transition: border-bottom 0.1s, border-top 0.1s 0.1s;
}

ul > li {
    @apply relative px-4 leading-[3em] cursor-pointer font-semibold tracking-[1px] rounded-md;
}

ul > li:hover {
    background-color: rgba(255, 255, 255, 0.2);
}
ul > li:active {
    background-color: rgba(255, 255, 255, 0.15);
}
</style>
