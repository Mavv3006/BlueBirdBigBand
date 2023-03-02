<template>
    <li ref="container" :style="{'z-index': zIndex ?? 'unset'}" class="text-white">
        <div v-if="link === undefined" class="container">{{ container_title }}</div>
        <div v-if="link !== undefined" class="container">
            <Link :as="as" :href="link" :method="method">{{ container_title }}</Link>
        </div>
        <button v-if="hasChildren" :class="{'open-submenu-bg-color': isOpenRef}"
                @click="toggle_submenu">
            <font-awesome-icon v-if="isOpenRef" icon="fa-solid fa-minus"/>
            <font-awesome-icon v-if="!isOpenRef" icon="fa-solid fa-plus"/>
        </button>
    </li>
    <li ref="submenu" :class="{'open-submenu':isOpenRef}" class="submenu">
        <slot/>
    </li>
</template>

<script lang="ts" setup>
import {computed, defineProps, ref} from 'vue';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {Link} from '@inertiajs/vue3';

interface Props {
    container_title: string,
    link?: string,
    zIndex?: string,
    method?: string,
    as?: string
}

const props = withDefaults(defineProps<Props>(), {
    container_title: '',
    method: undefined,
    as: undefined
});
const emits = defineEmits<{
    (e: 'update:isOpen', isOpen: boolean): void
}>();

const isOpenRef = ref<boolean>(false);
const container = ref<HTMLLIElement | null>(null);
const submenu = ref<HTMLLIElement | null>(null);

const submenu_children_count = () => {
    return submenu.value === null ? 0 : submenu.value.childElementCount;
};

const hasChildren = computed<boolean>(() => submenu_children_count() > 0);

const toggle_submenu = () => {
    isOpenRef.value = !isOpenRef.value;
};
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
