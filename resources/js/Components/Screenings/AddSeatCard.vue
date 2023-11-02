<script setup lang="ts">
import PlusIcon from '@/Components/Icons/PlusIcon.vue'

withDefaults(defineProps<{ isWidthFixed?: boolean }>(), { isWidthFixed: true })
</script>

<template>
  <div
    :class="[isWidthFixed ? 'w-3.5 sm:w-5' : 'w-full']"
    class="h-5 sm:h-7 rounded-[3px] flex items-center justify-center border border-white cursor-pointer"
  >
    <PlusIcon class="fill-white text-sm" />
  </div>
</template>
