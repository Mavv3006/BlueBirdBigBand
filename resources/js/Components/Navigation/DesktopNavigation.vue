<template>
    <ul class="text-white mt-3 gap-9 justify-center content-center">
        <li>Home</li>
        <li class="nav-container">Aktuelles</li>
        <li class="nav-container">Band</li>
        <li class="nav-container">Kontakt</li>
        <li>Login</li>
    </ul>
</template>

<script setup></script>

<style scoped>
.nav-container:after {
    content: "";
    position: absolute;
    display: block;
    top: 50%;
    right: 5px;
    width: 0;
    height: 0;
    border-top: 4px solid #d61000;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    transition: border-bottom 0.1s, border-top 0.1s 0.1s;
}

ul > li {
    @apply relative pr-5 pl-4 leading-[3em] cursor-pointer font-semibold tracking-[1px];
}
</style>
