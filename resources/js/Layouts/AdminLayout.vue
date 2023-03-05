<template>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li>
                <a href="#">Clients</a>
                <ul>
                    <li>
                        <a href="#">Burger King</a>
                    </li>
                    <li>
                        <a href="#">Southwest Airlines</a>
                    </li>
                    <li>
                        <a href="#">Levi Strauss</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">Services</a>
                <ul>
                    <li>
                        <a href="#">Print Design</a>
                    </li>
                    <li>
                        <a href="#">Web Design</a>
                    </li>
                    <li>
                        <a href="#">App Development</a>
                    </li>
                </ul>
            </li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
</template>

<script setup>

</script>

<style scoped>
nav ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

nav ul li {
    position: relative;
}

nav ul li:hover {
    background-color: rgba(0, 150, 255, 1.0);
}

nav ul a {
    color: #ffffff;
    text-decoration: none;
    display: block;
    padding: 10px 5px;
}

nav {
    position: fixed;
    width: 150px;
    left: -150px;
    top: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    padding: 15px 0;
    transition: left 300ms ease-in-out;
}

nav:after {
    content: '>>';
    font-weight: 400;
    font-style: normal;
    text-decoration: none;
    color: #ffffff;
    position: absolute;
    left: 100%;
    top: 0;
    padding: 15px;
    background-color: rgba(0, 0, 0, 0.9);
    border-bottom-right-radius: 5px;
    cursor: pointer;
}

nav:hover {
    left: 0;
    transition: left 300ms ease-in-out;
}

nav:hover:after {
    content: '<<';
}

nav > ul {
    margin-top: 32px;
}

nav ul li > ul {
    position: absolute;
    background-color: rgba(0, 0, 0, 0.9);
    width: 100%;
    top: 1999px;
    left: 100%;
    transition: top .5s;
}

nav ul li > ul li {
    min-width: 120px;
}

nav ul li:hover > ul,
nav ul li > ul:hover {
    top: 0;
}
</style>
