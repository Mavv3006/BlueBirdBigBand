<template>
    <div>
        <header>
            <h3>{{ name }}</h3>
        </header>
        <div class="mail">
            <div v-for="mail in emails">
                <div>
                    <p class="name">{{ mail.name }}</p>
                    <p>
                        <MailtoLink :mail-adress="mail.email">{{ mail.email }}</MailtoLink>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {defineProps} from 'vue';
import MailtoLink from "@/Components/Link/MailtoLink.vue";

export type EmailModel = {
    name: string,
    email: string
}
export type EmailGroupModel = {
    name: string,
    emails: EmailModel[]
};

const props = defineProps<EmailGroupModel>();

</script>

<style scoped>
.name {
    float: left;
    margin: 0 5px;
}

.mail {
    display: flex;
    gap: 2rem;
    flex-direction: column;
    margin-top: 5px;
}

header {
    margin-top: 1.5rem;
    font-size: 115%;
}
</style>
