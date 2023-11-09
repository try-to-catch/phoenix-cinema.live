<script setup lang="ts">
import type { IOption } from '@/types/forms/IOption'
import { computed, ref, toRefs } from 'vue'
import AngleDown from '@/Components/Icons/AngleDown.vue'

const props = defineProps<{
  modelValue: string | null
  placeholder: string
  searchKey: keyof IOption
  items: IOption[]
  disabled?: boolean
}>()
const { searchKey, items, modelValue, placeholder, disabled } = toRefs(props)

const emit = defineEmits<{
  'update:modelValue': [val: string]
}>()

const searchString = ref('')
const rememberPressedKeysTemporary = (val: string, duration = 1000) => {
  searchString.value = val

  setTimeout(() => (searchString.value = ''), duration)
}

const focusedItemId = ref('')

const listRef = ref<HTMLUListElement | null>(null)
const itemRefs = ref<Array<HTMLLIElement> | null>(null)

const updateScrollPosition = (e: KeyboardEvent) => {
  const key = searchString.value + e.key

  if (!listRef.value || !itemRefs.value) return
  const index = items.value.findIndex(item => {
    return (item[searchKey.value] as string).slice(0, key.length).toLowerCase() === key.toLowerCase()
  })

  if (index === -1 || !itemRefs.value[index]) return
  listRef.value.scrollTop = itemRefs.value[index].offsetTop
  focusedItemId.value = items.value[index].id

  rememberPressedKeysTemporary(key)
}

const isOpen = ref(false)
const toggleIsOpen = (value?: boolean) => {
  if (disabled.value) return
  isOpen.value = value ?? !isOpen.value
}

const buttonText = computed(() => {
  if (modelValue.value === null) return placeholder.value

  const matchedItem = items.value.find(item => item.id === modelValue.value)
  return matchedItem ? matchedItem[searchKey.value] : placeholder.value
})

const selectItem = (id: string) => {
  emit('update:modelValue', id)
}
</script>

<template>
  <div class="relative" @keydown="updateScrollPosition">
    <button
      id="dropdownDefaultButton"
      :class="{ 'focus:ring-1 focus:outline-none focus:ring-secondary': !disabled }"
      class="px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-primary rounded-lg border border-primary font-medium py-2.5 text-center inline-flex items-center"
      type="button"
      @focusout="toggleIsOpen(false)"
      @click="toggleIsOpen()"
      @keydown.enter="selectItem(focusedItemId)"
    >
      {{ buttonText }}
      <AngleDown v-if="!disabled" />
    </button>

    <Transition leave-active-class="duration-200">
      <div
        v-if="isOpen && items.length > 0"
        id="dropdown"
        class="bg-tertiary z-20 divide-y divide-gray-100 rounded-lg shadow w-full shadow-secondary absolute mt-2"
      >
        <ul ref="listRef" class="py-2 text-sm text-gray-700 max-h-40 overflow-auto rounded-lg">
          <li
            v-for="item in items"
            :key="item.id"
            ref="itemRefs"
            class="block px-4 py-2 text-white cursor-pointer"
            :class="[focusedItemId === item.id ? 'bg-neutral-800' : 'bg-tertiary']"
            @mouseover="focusedItemId = item.id"
            @click="selectItem(item.id)"
          >
            <slot :option="item">{{ item[searchKey] }}</slot>
          </li>
        </ul>
      </div>
    </Transition>
  </div>
</template>

<style scoped></style>
