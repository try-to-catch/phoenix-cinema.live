<script setup lang="ts">
import TextInput from '@/Components/Breeze/TextInput.vue'
import { computed, Ref, ref, toRefs, watch } from 'vue'

type suggestionType = { id: string; name: string }

const props = withDefaults(
  defineProps<{
    suggestions: readonly suggestionType[]
    modelValue: string[]
    id: string
    labelInner: string
    styles?: string
    placeholder?: string
    required?: boolean
  }>(),
  {
    styles: '',
    placeholder: '',
    required: false,
  }
)

const emit = defineEmits<{
  'update:modelValue': [value: string[]]
}>()

const { suggestions, modelValue } = toRefs(props)

const MAX_NUMBER_OF_SUGGESTED_ITEMS = 7
const filteredSuggestions = computed(() => {
  if (suggestions.value.length === 0) return [] as suggestionType[]

  let suitableSuggestionsCount = 0

  return suggestions.value.filter(suggestion => {
    if (suitableSuggestionsCount >= MAX_NUMBER_OF_SUGGESTED_ITEMS - selectedItems.value.length) return false
    if (modelValue.value.includes(suggestion.id)) return false
    if (!suggestion.name.includes(textInput.value)) return false

    suitableSuggestionsCount++
    return true
  })
})

const textInput = ref('')

// eslint-disable-next-line @typescript-eslint/no-redundant-type-constituents
const textInputRef: Ref<InstanceType<typeof TextInput> | null> = ref(null)
const clearTextInput = () => {
  textInput.value = ''

  if (textInputRef.value) {
    // eslint-disable-next-line @typescript-eslint/no-unsafe-member-access,@typescript-eslint/no-unsafe-call
    textInputRef.value.focus()
  }
}

const selectedItems = computed(() => {
  return modelValue.value.map(itemId => {
    return suggestions.value.find(item => item.id === itemId) as suggestionType
  })
})

const addItem = (index: number) => {
  textInput.value = filteredSuggestions.value[index].name
}

watch(textInput, value => {
  const res = suggestions.value.find(v => v.name.toLowerCase() == value.toLowerCase())

  if (res) {
    emit('update:modelValue', [...modelValue.value, res.id])
    clearTextInput()
  }
})

const unselectItem = (id: string) => {
  emit(
    'update:modelValue',
    modelValue.value.filter(item => item != id)
  )
}
</script>

<template>
  <TextInput
    id="id"
    ref="textInputRef"
    v-model="textInput"
    :styles="styles"
    :placeholder="placeholder"
    :required="required"
    type="text"
    :label-inner="labelInner"
  />

  <div class="flex space-x-1.5">
    <ul class="flex flex-wrap space-x-1.5 space-y-1.5 -mx-1.5">
      <li
        v-for="item in selectedItems"
        :key="item!.id"
        class="rounded-sm select-none bg-primary cursor-pointer border text-neutral-300 px-2.5 py-0.5 first-of-type:mt-1.5 first-of-type:ml-1.5 text-xs border-secondary"
        @dblclick="unselectItem(item.id)"
      >
        {{ item.name }}
      </li>
    </ul>

    <ul v-show="textInput !== ''" class="flex flex-wrap space-x-1.5 space-y-1.5">
      <li
        v-for="(suggestion, index) in filteredSuggestions"
        :key="index"
        class="rounded-sm bg-primary cursor-pointer border text-neutral-300 px-2.5 py-0.5 first-of-type:mt-1.5 text-xs border-neutral-800"
        @click="addItem(index)"
      >
        {{ suggestion.name }}
      </li>
    </ul>
  </div>
</template>

<style scoped></style>
