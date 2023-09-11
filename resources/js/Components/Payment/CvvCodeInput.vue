<script lang="ts" setup>
import TextInput from '@/Components/Breeze/TextInput.vue'
import { ref, watchEffect } from 'vue'

const props = withDefaults(
  defineProps<{
    modelValue: string
    required?: boolean
  }>(),
  { required: false }
)
const cvvCode = ref(props.modelValue)

const emit = defineEmits<{
  'update:modelValue': [value: string]
}>()

const filterCardNumber = () => {
  cvvCode.value = cvvCode.value.replace(/\D/g, '').slice(0, 3) || ''
}

watchEffect(() => {
  emit('update:modelValue', cvvCode.value)
})
</script>

<template>
  <TextInput
    id="cvv_code"
    v-model="cvvCode"
    label-inner="CVV код"
    :required="required"
    type="text"
    @input="filterCardNumber"
  />
</template>

<style scoped></style>
