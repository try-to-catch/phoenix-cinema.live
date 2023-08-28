<script lang="ts" setup>

import PaymentModal from "@/Components/Modals/PaymentModal.vue";
import PaymentForm from "@/Components/Payment/PaymentForm.vue";
import useWindow from "@/composables/window";

defineProps<{ totalPrice: number }>()
const {width} = useWindow()
</script>

<template>
  <section>
    <div class="container">
      <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
        <PaymentForm v-if="width <= 768" :total-price="totalPrice"/>
        <PaymentModal v-else :total-price="totalPrice"/>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>
