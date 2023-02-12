<template>
    <li ref="container">
        <div v-if="link === undefined" class="container">{{ container_title }}</div>
        <div v-if="link !== undefined" class="container">
            <Link :href="link">{{ container_title }}</Link>
        </div>
        <button v-if="has_children" :class="{'open-submenu-bg-color': isOpenRef}" @click="toggle_submenu">
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
    is_open: boolean,
    link?: string
}

const propDefaults: Props = {
    container_title: '',
    is_open: false
}

const props = withDefaults(defineProps<Props>(), propDefaults);
const emits = defineEmits<{
    (e: 'update:isOpen', isOpen: boolean): void
}>();

const isOpenRef = ref<boolean>(props.is_open);
const container = ref<HTMLLIElement | null>(null);
const submenu = ref<HTMLLIElement | null>(null);

const submenu_children_count = computed<number>(() => {
    if (submenu.value === null) return 0;
    return submenu.value.childElementCount;
});

const has_children = computed<boolean>(() => submenu_children_count > 0);

const toggle_submenu = computed<void>(() => {
    isOpenRef.value = !isOpenRef.value;
    emits('update:isOpen', isOpenRef.value)
});
</script>

<style scoped>

</style>
