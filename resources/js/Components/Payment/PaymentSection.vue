<script lang="ts" setup>
import PaymentForm from '@/Components/Payment/PaymentForm.vue'
import useWindow from '@/composables/window'
import PaymentModal from '@/Components/Modals/PaymentModal.vue'
import type { ICardData } from '@/types/payments/ICardData'
import { computed } from 'vue'
import type { OrderFormType } from '@/types/orders/OrderFormType'

defineProps<{
  totalPrice: number
  modelValue: ICardData
  errors: Partial<Record<keyof OrderFormType, string>>
}>()

const emit = defineEmits<{
  'update:modelValue': [value: ICardData]
  submit: []
}>()

const { width } = useWindow()
const isFormShouldBeShown = computed(() => width.value <= 768)

const onSubmit = () => {
  emit('submit')
}
</script>

<template>
  <section>
    <div class="container">
      <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
        <PaymentForm
          v-if="isFormShouldBeShown"
          :errors="errors"
          :model-value="modelValue"
          :total-price="totalPrice"
          @submit="onSubmit"
          @update:model-value="emit('update:modelValue', $event)"
        />
        <PaymentModal
          v-else
          :errors="errors"
          :model-value="modelValue"
          :total-price="totalPrice"
          @submit="onSubmit"
          @update:model-value="emit('update:modelValue', $event)"
        />
      </div>
    </div>
  </section>
</template>

<style scoped></style>
