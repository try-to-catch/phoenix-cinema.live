<script lang="ts" setup>
import { onMounted, ref } from 'vue'

withDefaults(
  defineProps<{
    modelValue: File | null
    id: string
    labelInner: string
    styles?: string
    required?: boolean
  }>(),
  {
    styles: '',
    required: false,
  }
)

defineEmits<{
  'update:modelValue': [value: File | null]
}>()

const input = ref<HTMLInputElement | null>(null)

onMounted(() => {
  if (input.value?.hasAttribute('autofocus')) {
    input.value?.focus()
  }
})
</script>

<template>
  <div class="relative">
    <input
      :id="id"
      ref="input"
      :class="[styles]"
      :required="required"
      :value="modelValue"
      type="file"
      class="peer block px-2.5 py-2 w-full text-sm text-white bg-tertiary rounded-lg border-neutral-800 appearance-none border cursor-pointer focus:outline-none focus:ring-0 focus:border-secondary file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-1 file:border-neutral-800 file:border-solid file:text-sm file:font-semibold file:bg-primary file:text-neutral-200 hover:file:bg-neutral-900 file:duration-300 file:cursor-pointer file:ease-in-out"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    />

    <label
      :for="id"
      class="absolute text-sm text-neutral-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-tertiary rounded-md px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
    >
      {{ labelInner }}
    </label>
  </div>
</template>
