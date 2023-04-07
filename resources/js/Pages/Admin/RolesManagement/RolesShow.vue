<template>
    <PublicLayout>
        <Heading>Rolle: {{ role.name }}</Heading>
        <Head><title>Rolle {{ role.name }}</title></Head>

        <div class="flex gap-6 justify-center">
            <div class="w-1/3 h-[250px]">
                <select ref="left_list" name="list left" id="1" multiple class="w-full h-full">
                    <option v-for="element in l1" :value="element">{{ element }}</option>
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
                <select ref="right_list" name="list right" id="2" multiple class="w-full h-full">
                    <option v-for="element in l2" :value="element">{{ element }}</option>
                </select>
            </div>
        </div>
    </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Heading from "@/Components/Heading.vue";
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";

const left_list = ref<HTMLSelectElement | null>(null);
const right_list = ref<HTMLSelectElement | null>(null);

let l1 = ref<any>(["o", "i", "u", "z", "t", "r"]);
let l2 = ref<any>(["a", "b", "c", "d", "e", "f"]);

const props = defineProps<{ role: { id: number, name: string } }>();

const moveLeft = () => {
    const selectedOptions = right_list.value.selectedOptions;
    if (selectedOptions.length == 0) {
        console.debug("nothing selected");
        return;
    }
    for (let i = 0; i < selectedOptions.length; i++) {
        const item = selectedOptions.item(i);
        const index = l2.value.indexOf(item.value);
        if (index === -1) {
            console.debug("item not found");
        }
        l1.value.push(item.value);
        l2.value.splice(index, 1);
    }
};
const moveRight = () => {
    const selectedOptions = left_list.value.selectedOptions;
    if (selectedOptions.length == 0) {
        console.debug("nothing selected");
        return;
    }
    for (let i = 0; i < selectedOptions.length; i++) {
        const item = selectedOptions.item(i);
        const index = l1.value.indexOf(item.value);
        if (index === -1) {
            console.debug("item not found");
        }
        l2.value.push(item.value);
        l1.value.splice(index, 1);
    }
};
</script>
