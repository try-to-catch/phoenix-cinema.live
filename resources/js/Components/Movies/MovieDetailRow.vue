<script setup lang="ts">


const {title, value} = defineProps<{ title: string, value: string | number }>()
</script>

<template>
  <li class="flex flex-col sm:flex-row items-baseline sm:space-x-4 lg:text-base text-sm">
    <h6 class="md:w-[150px] sm:w-[120px] w-full shrink-0 font-medium text-white">{{ title }}</h6>
    <p class="text-neutral-400">{{ value }}</p>
  </li>
</template>
