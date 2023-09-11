<script setup lang="ts">
defineProps<{ text?: string }>()
</script>

<template>
  <h5 class="font-medium text-white text-base sm:text-lg">
    {{ text }}
    <template v-if="$slots.default && !text">
      <slot />
    </template>
  </h5>
</template>
