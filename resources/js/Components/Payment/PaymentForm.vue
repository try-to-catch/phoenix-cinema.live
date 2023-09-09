<script lang="ts" setup>
import NumberInput from "@/Components/Breeze/NumberInput.vue";
import SummarizingRow from "@/Components/Payment/SummarizingRow.vue";
import PrimaryButton from "@/Components/Breeze/PrimaryButton.vue";
import H5Title from "@/Components/Titles/H5Title.vue";
import CardNumberInput from "@/Components/Payment/CardNumberInput.vue";
import CvvCodeInput from "@/Components/Payment/CvvCodeInput.vue";
import type {ICardData} from "@/types/payments/ICardData";
import {toRefs, watch} from "vue";

const props = defineProps<{
  totalPrice: number;
  modelValue: ICardData
}>()

const emit = defineEmits<{
  'update:modelValue': [value: ICardData],
  'submit': []
}>()

const {modelValue: form} = toRefs(props)

const currentYear = new Date().getFullYear()

watch(form.value, () => {
  emit('update:modelValue', form.value)
})
</script>

<template>
  <form @submit.prevent="emit('submit')">
    <H5Title>Оплата</H5Title>

    <!--request card number, expire date and cvv code-->
    <div class="mt-4">
      <CardNumberInput v-model="form.card_number" required/>

      <div class="grid grid-cols-3 gap-4 mt-4">
        <NumberInput id="expire_month" v-model.trim="form.expire_month" :max="12" label-inner="Місяць" required/>
        <NumberInput id="expire_year" v-model.trim="form.expire_year" :max="currentYear + 10" label-inner="Рік"
                     required/>

        <CvvCodeInput v-model="form.cvv_code" required/>
      </div>
    </div>

    <div class="mt-8">
      <SummarizingRow :total="totalPrice" small-text="грн" title="Загальна сума"/>

      <PrimaryButton class="sm:text-base mt-4">
        Сплатити
      </PrimaryButton>
    </div>
  </form>
</template>
