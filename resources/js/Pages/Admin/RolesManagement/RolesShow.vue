<template>
    <PublicLayout>
        <Heading>Rolle: {{ role.name }}</Heading>
        <Head><title>Rolle {{ role.name }}</title></Head>

        <div class="flex gap-6 justify-center">
            <div class="w-1/3 h-[250px]">
                <div class="text-sm text-gray-600 text-center w-full">Verfügbare Permissions</div>
                <select ref="left_list" name="list left" id="1" multiple class="w-full h-[230px]">
                    <option v-for="element in l1" :value="element">{{ permissionName(element) }}</option>
                </select>
            </div>
            <div class="w-[50px] flex flex-col justify-center gap-8">
                <div
                    class="h-[50px] flex justify-center items-center border rounded-md border-slate-700 hover:bg-gray-100 active:bg-gray-200"
                    @click="moveLeft">
                    <font-awesome-icon icon="fa-solid fa-chevron-left"/>
                </div>
                <div
                    class="h-[50px] flex justify-center items-center border rounded-md border-slate-700 hover:bg-gray-100 active:bg-gray-200"
                    @click="moveRight">
                    <font-awesome-icon icon="fa-solid fa-chevron-right"/>
                </div>
            </div>
            <div class="w-1/3 h-[250px]">
                <div class="text-sm text-gray-600 text-center w-full">Zugewiesene Permissions</div>
                <select ref="right_list" name="list right" id="2" multiple class="w-full h-[230px]">
                    <option v-for="element in l2" :value="element">{{ permissionName(element) }}</option>
                </select>
            </div>
        </div>

        <div class="flex mt-4 justify-center">
            <PrimaryButton>Speichern</PrimaryButton>
        </div>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";
import PrimaryButton
    from "../../../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/PrimaryButton.vue";

const props = defineProps<{
    role: { id: number, name: string },
    role_permissions: { id: number }[],
    not_used_permissions: { id: number }[],
    all_permissions: { id: number, name: string }[],
}>();

const left_list = ref<HTMLSelectElement | null>(null);
const right_list = ref<HTMLSelectElement | null>(null);

let l1 = ref<any>(props.not_used_permissions.map(value => value.id));
let l2 = ref<any>(props.role_permissions.map(value => value.id));

// console.debug(props);

const permissionName = (id: number | string): string => {
    return props.all_permissions.filter((value) => value.id === +id)[0].name
};

const moveLeft = () => {
    const selectedOptions = right_list.value.selectedOptions;
    if (selectedOptions.length == 0) {
        console.info("nothing selected");
        return;
    }
    for (let i = 0; i < selectedOptions.length; i++) {
        const item = selectedOptions.item(i);
        const index1 = l2.value.indexOf(item.value);
        const index2 = l2.value.indexOf(+item.value);
        if (index1 === -1 && index2 === -1) {
            console.warn("item not found");
            return;
        }
        l1.value.push(item.value);
        l2.value.splice(Math.max(index1, index2), 1);
    }
};
const moveRight = () => {
    const selectedOptions = left_list.value.selectedOptions;
    if (selectedOptions.length == 0) {
        console.info("nothing selected");
        return;
    }
    for (let i = 0; i < selectedOptions.length; i++) {
        const item = selectedOptions.item(i);
        const index1 = l1.value.indexOf(item.value);
        const index2 = l1.value.indexOf(+item.value);
        if (index1 === -1 && index2 === -1) {
            console.warn("item not found");
            return;
        }
        l2.value.push(item.value);
        l1.value.splice(Math.max(index1, index2), 1);
    }
};
</script>
