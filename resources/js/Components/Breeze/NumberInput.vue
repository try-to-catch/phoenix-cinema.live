<script lang="ts" setup>
import { onMounted, ref, watchEffect } from 'vue'

const props = withDefaults(
  defineProps<{
    modelValue: number | null
    id: string
    labelInner: string
    max: number
    styles?: string
    placeholder?: string
    required?: boolean
    autofocus?: boolean
    autocomplete?: string
    min?: number
  }>(),
  {
    min: 1,
    styles: '',
    placeholder: '',
    required: false,
    autofocus: false,
    autocomplete: 'off',
  }
)

const emit = defineEmits<{
  'update:modelValue': [value: number | null]
}>()

const input = ref<HTMLInputElement | null>(null)

onMounted(() => {
  if (input.value?.hasAttribute('autofocus')) {
    input.value?.focus()
  }
})

const inputValue = ref<number | null>(props.modelValue)
const filterValue = () => {
  if (inputValue.value === null) return

  if (props.max) {
    inputValue.value = Number(inputValue.value?.toString().slice(0, props.max.toString().length)) || null

    if (inputValue.value! > props.max) {
      inputValue.value = props.max
    }
  }

  if (inputValue.value! < props.min) {
    inputValue.value = props.min
  }
}

watchEffect(() => {
  inputValue.value = Number(inputValue.value?.toString().replace(/[^0-9]/g, '')) || null
  emit('update:modelValue', inputValue.value)
})

defineExpose({ focus: () => input.value?.focus() })
</script>

<template>
  <div class="relative">
    <input
      :id="id"
      ref="input"
      v-model.number="inputValue"
      :autocomplete="autocomplete"
      :autofocus="autofocus"
      :class="[styles]"
      :max="max"
      :min="min"
      :placeholder="placeholder"
      :required="required"
      class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-tertiary rounded-lg border-1 border-neutral-800 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer"
      type="number"
      @input="filterValue"
    />
    <label
      :for="id"
      class="absolute text-sm text-neutral-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-tertiary rounded-md px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
    >
      {{ labelInner }}
    </label>
  </div>
</template>
