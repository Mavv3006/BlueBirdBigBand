<template>
  <div
      class="h-[60px] bg-white text-primary relative drop-shadow-[0_7px_12px_white]
      lg:h-[90px]">
    <div
        class="font-roboto font-bold text-[24px] leading-[60px] h-full text-center
        md:text-left md:ml-[60px]
        lg:leading-[90px] lg:text-[32px]">
      <a href="/v2/">Blue Bird Big Band</a>
    </div>
    <font-awesome-icon
        class="absolute cursor-pointer top-[15px] h-[30px] right-[30px]
        lg:hidden"
        icon="fa-solid fa-bars"/>
  </div>
</template>

<script lang="ts" setup>
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
</script>

<style scoped>
</style>