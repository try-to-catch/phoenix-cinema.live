<script lang="ts" setup>
defineProps<{ title: string }>()
</script>

<template>
  <li
    class="w-full h-full bg-tertiary rounded-md md:p-10 sm:p-8 p-6 border border-neutral-800 relative hover:border-secondary duration-500 cursor-pointer"
  >
    <h5 class="md:text-xl text-lg font-medium sm:uppercase">
      {{ title }}
    </h5>

    <p class="text-sm md:text-base mt-2 font-sans">
      <slot name="text" />
    </p>

    <slot name="emoji" />
  </li>
</template>
