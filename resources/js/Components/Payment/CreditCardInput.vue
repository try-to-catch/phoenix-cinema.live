<script lang="ts" setup>

import {computed, ref, watchEffect} from "vue";
import TextInput from "@/Components/Breeze/TextInput.vue";

const {modelValue: cardNumber, required} = withDefaults(
    defineProps<{
      modelValue: number | null,
      required?: boolean
    }>(),
    {required: false}
)

const emit = defineEmits<{
  'update:modelValue': [value: number | null]
}>()

const cardNumberString = ref(cardNumber?.toString().replace(/(.{4})/g, '$1 ') || '')

const formattedCardNumber = computed(() => {
  return cardNumberString.value.replace(/(.{4})/g, '$1 ').slice(0, 24) || ''
})

const filterCardNumber = () => {
  cardNumberString.value = formattedCardNumber.value.replace(/\D/g, '') || ''
}

const updateCardNumber = (value: string) => {
  cardNumberString.value = value
}

watchEffect(() => {
  emit('update:modelValue', Number(cardNumberString.value.replace(/\s/g, '')) || null)
})

</script>

<template>
  <TextInput id="card_number" :model-value="formattedCardNumber" label-inner="Номер картки"
             :required="required" type="text" @input="filterCardNumber" @update:model-value="updateCardNumber"/>

</template>

<style scoped>

</style>
