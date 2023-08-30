<template>
    <div class="gap-6 flex flex-col">
        <div class="flex gap-3 justify-between" v-for="concert in concerts">
            <Concert :concert="concert" class="col-span-2"/>

            <div class="self-center flex gap-3 flex-col col-span-1">
                <Link :href="`/admin/concerts/${concert.id}/edit`" class="mr-1 w-fit">
                    <font-awesome-icon icon="fa-solid fa-pen"/>
                </Link>

                <Link :href="`/admin/concerts/${concert.id}`" method="delete" class="text-red-600 w-fit">
                    <font-awesome-icon icon="fa-solid fa-trash"/>
                </Link>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Concert as ConcertType} from "@/types/concert";
import Concert from "@/Components/Concert.vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps<{ concerts: ConcertType[] }>();
</script>

<style scoped>

</style>
