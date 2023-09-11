<script setup lang="ts">
import H5Title from '@/Components/Titles/H5Title.vue'

defineProps<{ title: string; total: number; smallText?: string }>()
</script>

<template>
  <div class="flex justify-between items-center w-full">
    <H5Title>{{ title }}</H5Title>

    <H5Title>
      {{ total }}
      <small v-if="smallText" class="text-xs">{{ smallText }}</small>
    </H5Title>
  </div>
</template>

<style scoped></style>
