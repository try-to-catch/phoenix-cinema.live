<script lang="ts" setup>
defineProps<{ isActive: boolean }>()
</script>

<template>
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path
      :class="{ hidden: isActive, 'inline-flex': !isActive }"
      d="M4 6h16M4 12h16M4 18h16"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke-width="2"
    />
    <path
      :class="{ hidden: !isActive, 'inline-flex': isActive }"
      d="M6 18L18 6M6 6l12 12"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke-width="2"
    />
  </svg>
</template>

<style scoped></style>
