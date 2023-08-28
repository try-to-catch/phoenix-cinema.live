<script lang="ts" setup>
import TextInput from "@/Components/Breeze/TextInput.vue";
import NumberInput from "@/Components/Breeze/NumberInput.vue";
import SummarizingRow from "@/Components/Payment/SummarizingRow.vue";
import PrimaryButton from "@/Components/Breeze/PrimaryButton.vue";
import H5Title from "@/Components/Titles/H5Title.vue";
import usePayment from "@/composables/payment";

defineProps<{ totalPrice: number }>()

const currentYear = new Date().getFullYear()

const {form} = usePayment()

</script>

<template>
  <form @submit.prevent="console.log('payment')">
    <H5Title>Оплата</H5Title>

    <!--request card number, expire date and cvv code-->
    <form class="mt-4">
      <TextInput id="card_number" v-model="form.cardNumber" label-inner="Номер картки" required type="text"/>

      <div class="grid grid-cols-3 gap-4 mt-4">
        <NumberInput id="expire_month" v-model="form.expireMonth" :max="12" :min="1" label-inner="Місяць" required/>
        <NumberInput id="expire_year" v-model="form.expireYear" :max="2040" :min="currentYear"
                     label-inner="Рік" required/>
        <NumberInput id="cvv_code" v-model="form.cvvCode" :max="999" :min="0" label-inner="CVV код" required/>
      </div>
    </form>

    <div class="mt-8">
      <SummarizingRow :total="totalPrice" small-text="грн" title="Загальна сума"/>

      <PrimaryButton class="sm:text-base mt-4">
        Сплатити
      </PrimaryButton>
    </div>
  </form>
</template>
