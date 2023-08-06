<template>
  <div class="header">
    <div class="lg:flex lg:justify-between lg:items-center h-full">
      <div class="title">
        <a href="/v2/">Blue Bird Big Band</a>
      </div>
      <div class="hidden mr-[60px] gap-12 relative items-center lg:flex">
        <NavigationElement name="Band"/>
        <NavigationElement name="Auftritte"/>
        <NavigationElement name="Kontakt"/>
        <CallToActionButton name="Login"/>
      </div>
    </div>
    <font-awesome-icon
        class="absolute cursor-pointer top-[15px] h-[30px] right-[30px]
        lg:hidden"
        icon="fa-solid fa-bars"/>
  </div>
</template>

<script lang="ts" setup>
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import NavigationElement from "@/Components/v2/Navigation/NavigationElement.vue";
import CallToActionButton from "@/Components/v2/CallToActionButton.vue";
</script>

<style scoped>
.header {
  @apply h-[60px] bg-white text-primary relative shadow-[0_0_12px_11px_white]
  lg:h-[90px];
}

.title {
  @apply font-roboto font-bold text-[24px] text-center flex items-center justify-center h-full
  md:text-left md:ml-[60px] lg:text-[32px];
}
</style>