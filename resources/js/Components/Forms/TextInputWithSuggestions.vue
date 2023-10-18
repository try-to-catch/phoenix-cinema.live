<script setup lang="ts">
import TextInput from '@/Components/Breeze/TextInput.vue'
import { computed, ref, toRefs } from 'vue'

type suggestionType = { id: string; name: string }

const props = withDefaults(
  defineProps<{
    suggestions: readonly suggestionType[]
    // modelValue: string | null
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

const { suggestions } = toRefs(props)

const MAX_NUMBER_OF_SUGGESTED_ITEMS = 5
const filteredSuggestions = computed(() => {
  if (suggestions.value.length === 0) return [] as suggestionType[]

  let suitableSuggestionsCount = 0

  return suggestions.value.filter(suggestion => {
    if (suitableSuggestionsCount >= MAX_NUMBER_OF_SUGGESTED_ITEMS) return false

    if (suggestion.name.includes(textInput.value)) {
      suitableSuggestionsCount++
      return true
    }

    return false
  })
})

const textInput = ref('')
const updateTextInput = (value: string) => {
  const splitInput = textInput.value.split(' ')
  splitInput[splitInput.length - 1] = value
  textInput.value = splitInput.join(' ')
}

const testArray = ref<string[]>([])

const addItem = (index: number) => {
  const value = filteredSuggestions.value[index]
  testArray.value.push(value.id)

  updateTextInput(value.name)
}

// watch()
</script>

<template>
  <TextInput
    id="id"
    v-model="textInput"
    :styles="styles"
    :placeholder="placeholder"
    :required="required"
    type="text"
    :label-inner="labelInner"
    title="Введіть жанри через пробіл"
  />
  <div v-show="textInput !== ''">
    <ul class="flex flex-wrap space-x-1.5 space-y-1.5">
      <li
        v-for="(suggestion, index) in filteredSuggestions"
        :key="index"
        :class="[textInput === suggestion.name ? 'border-secondary' : 'border-neutral-800']"
        class="rounded-sm bg-primary cursor-pointer border text-neutral-300 px-2.5 py-0.5 first-of-type:mt-1.5 text-xs"
        @click="addItem(index)"
      >
        {{ suggestion.name }}
      </li>
    </ul>
  </div>
</template>

<style scoped></style>
