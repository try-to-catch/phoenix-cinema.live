<script setup lang="ts">
defineProps<{ text?: string }>()
</script>

<template>
  <h3 class="md:text-3xl sm:text-2xl text-2xl font-bold text-white">
    {{ text }}
    <template v-if="$slots.default && !text">
      <slot/>
    </template>
  </h3>
</template>
