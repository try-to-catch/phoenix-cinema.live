<script lang="ts" setup>
import { computed, ref, watchEffect } from 'vue'
import TextInput from '@/Components/Breeze/TextInput.vue'

const { modelValue, required } = withDefaults(
  defineProps<{
    modelValue: string
    required?: boolean
  }>(),
  { required: false }
)

const cardNumber = ref(modelValue)

const emit = defineEmits<{
  'update:modelValue': [value: string]
}>()

const formattedCardNumber = computed(() => {
  return cardNumber.value.replace(/(.{4})/g, '$1 ').slice(0, 23) || ''
})

const filterCardNumber = () => {
  cardNumber.value = formattedCardNumber.value.replace(/\D/g, '') || ''
}

const updateCardNumber = (value: string) => {
  cardNumber.value = value
}

watchEffect(() => {
  emit('update:modelValue', cardNumber.value.replace(/\s/g, ''))
})
</script>

<template>
  <TextInput
    id="card_number"
    :model-value="formattedCardNumber"
    :required="required"
    label-inner="Номер картки"
    type="text"
    @input="filterCardNumber"
    @update:model-value="updateCardNumber"
  />
</template>

<style scoped></style>
