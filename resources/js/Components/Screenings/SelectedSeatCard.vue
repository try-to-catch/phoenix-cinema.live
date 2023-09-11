<script setup lang="ts">
import XMark from '@/Components/Icons/XMark.vue'

defineProps<{
  row: number
  seat: number
  price: number
  type: string
}>()

const emit = defineEmits<{ (e: 'remove'): void }>()
</script>

<template>
  <div
    class="w-full bg-tertiary sm:py-4 py-3 sm:pl-5 pl-4 sm:pr-12 pr-10 flex border border-neutral-700 rounded-md justify-between items-center relative"
  >
    <div class="flex space-x-4">
      <div class="text-center">
        <div class="text-md md:text-xl text-white font-medium">
          {{ row }}
        </div>
        <div class="text-xs md:text-sm text-white font-light">ряд</div>
      </div>
      <div class="text-center">
        <div class="text-md md:text-xl text-white font-medium">
          {{ seat }}
        </div>
        <div class="text-xs md:text-sm text-white font-light">місце</div>
      </div>
    </div>

    <div>
      <div class="text-secondary font-semibold">
        <span class="md:text-xl text-lg">{{ price }}</span>
        <small class="text-xs">грн</small>
      </div>

      <div class="text-[0.625rem] text-neutral-400">
        тип <span class="md:font-medium font-normal">{{ type }}</span>
      </div>
    </div>

    <div
      class="absolute right-2 cursor-pointer fill-neutral-400 hover:fill-secondary duration-300"
      @click="emit('remove')"
    >
      <XMark class="md:h-6 md:w-6 w-5 h-5" />
    </div>
  </div>
</template>
