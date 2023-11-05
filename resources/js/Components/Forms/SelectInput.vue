<script setup lang="ts">
/*defineProps<{
  id: string
  fieldName: string
}>()*/
import { ref } from 'vue'

const updateScrollPosition = (e: KeyboardEvent) => {
  console.log(e.key)
}
const isFocused = ref(false)
const toggleIsFocused = () => (isFocused.value = !isFocused.value)
</script>

<template>
  <div class="relative" @keydown="updateScrollPosition">
    <button
      id="dropdownDefaultButton"
      class="px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-primary rounded-lg border border-primary focus:ring-1 focus:outline-none focus:ring-secondary font-medium py-2.5 text-center inline-flex items-center"
      type="button"
      @click="toggleIsFocused"
    >
      Dropdown button
      <svg
        class="w-2.5 h-2.5 ml-2.5"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 10 6"
      >
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
      </svg>
    </button>

    <div
      v-if="isFocused"
      id="dropdown"
      class="bg-tertiary z-10 divide-y divide-gray-100 rounded-lg shadow w-full shadow-secondary absolute mt-2"
    >
      <ul class="py-2 text-sm text-gray-700">
        <li class="block px-4 py-2 bg-tertiary hover:bg-neutral-800 focus:bg-neutral-800 text-white cursor-pointer">
          Dashboard
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped></style>
