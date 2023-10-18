<script lang="ts" setup>
import { onMounted, ref } from 'vue'

withDefaults(
  defineProps<{
    modelValue: string | null
    id: string
    type: string
    labelInner: string
    styles?: string
    placeholder?: string
    required?: boolean
    autofocus?: boolean
    autocomplete?: string
  }>(),
  {
    styles: '',
    placeholder: '',
    required: false,
    autofocus: false,
    autocomplete: 'off',
  }
)

defineEmits<{
  'update:modelValue': [value: string | null]
}>()

const input = ref<HTMLInputElement | null>(null)

onMounted(() => {
  if (input.value?.hasAttribute('autofocus')) {
    input.value?.focus()
  }
})

defineExpose({ focus: () => input.value?.focus() })
</script>

<template>
  <div class="relative">
    <input
      :id="id"
      ref="input"
      :autocomplete="autocomplete"
      :autofocus="autofocus"
      :class="[styles]"
      :placeholder="placeholder"
      :required="required"
      :type="type"
      :value="modelValue"
      class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-tertiary rounded-lg border-1 border-neutral-800 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer"
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
