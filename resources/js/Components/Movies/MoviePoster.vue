<script setup lang="ts">
defineProps<{
  title: string
  thumbnail: string
  ageRestriction: string
}>()
</script>

<template>
  <div class="relative">
    <img :alt="`Постер ${title}`" :src="thumbnail" class="rounded-md h-full w-full" />

    <div class="w-8 h-8 text-xs absolute rounded-md top-2 left-2 bg-white flex justify-center items-center">
      {{ ageRestriction }}
    </div>
  </div>
</template>

<style scoped></style>
