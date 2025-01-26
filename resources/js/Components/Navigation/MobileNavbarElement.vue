<template>
    <li class="text-white">
        <div v-if="element.link === undefined" class="container">{{ element.linkName }}</div>
        <div v-if="element.link !== undefined" class="container">
            <Link v-if="element.linkName === 'Logout'" :href="element.link" :onSuccess="onSuccess" as="button"
                  method="post">
                {{ element.linkName }}
            </Link>

            <Link v-else :href="element.link">
                {{ element.linkName }}
            </Link>

        </div>
        <button v-if="(submenu === null ? 0 : submenu.childElementCount) > 0"
                :class="{'open-submenu-bg-color': isOpenRef}"
                @click="isOpenRef = !isOpenRef">
            <font-awesome-icon v-if="isOpenRef" icon="fa-solid fa-minus"/>
            <font-awesome-icon v-if="!isOpenRef" icon="fa-solid fa-plus"/>
        </button>
    </li>
    <li ref="submenu" :class="{'open-submenu':isOpenRef}" class="submenu">
        <p v-for="submenu in element.submenu" :key="submenu.linkName"
           class="p-[14px] pl-[34px] text-[14px] tracking-[1px] bg-[#d61000] text-white submenu-element">
            <Link :href="submenu.link">{{ submenu.linkName }}</Link>
        </p>
    </li>
</template>

<script lang="ts" setup>
import {defineProps, ref} from 'vue';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {Link} from '@inertiajs/vue3';
import {Route} from "@/Composables/useRoutes";

const props = defineProps<{ element: Route }>();
const isOpenRef = ref<boolean>(false);
const submenu = ref<HTMLLIElement | null>(null);

const onSuccess = () => window.location.reload();
</script>

<style scoped>
.open-submenu-bg-color {
    background-color: hsl(234, 94%, 45%);
}

.container {
    padding: 17px;
    font-size: 15px;
    letter-spacing: 1px;
}

a {
    text-decoration: none;
    display: block;
}

a, a:visited, a:hover, a:active {
    color: white;
}

li:not(.submenu) {
    border: 0;
    list-style: none;
    line-height: 1;
    display: flex;
    position: relative;
    height: 49px;
    justify-content: space-between;
    background-color: #041286;
    transition: all ease 0.3s;
}

li:not(.submenu) > button {
    color: white;
    padding-right: 17px;
    padding-left: 17px;
    transition: all ease 0.3s;
}

.submenu {
    display: none;
    transition: all ease 0.3s;
}

.submenu.open-submenu {
    display: block;
}
</style>
