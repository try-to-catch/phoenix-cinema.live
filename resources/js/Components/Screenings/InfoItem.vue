<script lang="ts" setup>

defineProps<{
  topText: string;
  bottomText: string;
}>()
</script>

<template>
  <div class="flex border border-neutral-700 rounded-md">
    <div class="w-[60px] h-full flex justify-center items-center rounded-l-md">
      <slot/>
    </div>
    <div class="text-white py-3 px-5 space-y-0.5 bg-tertiary rounded-r-md">
      <div class="text-sm text-neutral-400 font-light">{{ topText }}</div>
      <div class="font-medium text-sm text-white">{{ bottomText }}</div>
    </div>
  </div>
</template>

<style scoped>

</style>
