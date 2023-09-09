<script lang="ts" setup>
import Modal from "@/Components/Breeze/Modal.vue";
import {ref} from "vue";
import PaymentForm from "@/Components/Payment/PaymentForm.vue";
import PrimaryButton from "@/Components/Breeze/PrimaryButton.vue";
import XMark from "@/Components/Icons/XMark.vue";
import {ICardData} from "@/types/payments/ICardData";

defineProps<{ totalPrice: number, modelValue: ICardData }>()
const emit = defineEmits<{
  'update:modelValue': [value: ICardData],
  'submit': []
}>()
const isOpen = ref(false)

</script>

<template>
  <div>
    <PrimaryButton class="sm:text-base" @click="isOpen = true">Сплатити</PrimaryButton>

    <Modal :show="isOpen" closeable has-bg-blur max-width="2xl" styles="relative" @close="isOpen = false">
      <PaymentForm :model-value="modelValue" :total-price="totalPrice"
                   class="p-8" @submit="emit('submit')"
                   @update:model-value="emit('update:modelValue', $event)"/>

      <XMark class="absolute top-4 right-4 cursor-pointer fill-white" @click="isOpen = false"/>
    </Modal>

  </div>

</template>
