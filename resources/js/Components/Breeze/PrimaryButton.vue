<script setup lang="ts">
defineProps<{ type?: 'button' | 'submit' | 'reset' }>()
</script>

<template>
  <button
    :type="type"
    class="w-full text-white bg-secondary hover:bg-orange-550 duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-orange-400 font-medium rounded-lg text-sm px-5 py-2.5"
  >
    <slot />
  </button>
</template>
