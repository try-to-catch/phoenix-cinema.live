<script setup lang="ts">
import { ref } from 'vue'

defineProps<{ image: string }>()

const isMouseOverBanner = ref(false)
</script>

<template>
  <div
    class="h-full relative scroll-smooth flex overflow-hidden rounded-3xl"
    @mouseover="isMouseOverBanner = true"
    @mouseleave="isMouseOverBanner = false"
  >
    <div
      :class="{ 'scale-105': isMouseOverBanner }"
      :style="`background-image: url(${image});`"
      class="absolute bg-center bg-cover w-full h-full bg-no-repeat rounded-3xl flex active duration-500 ease"
    >
      <div class="absolute h-full w-full top-0">
        <div class="h-full w-full absolute rounded-[0.58rem]" :class="$style['gradient-0']" />
      </div>
    </div>

    <div class="z-10 flex">
      <slot />
    </div>
  </div>
</template>

<style module>
.gradient-0 {
  background: linear-gradient(180deg, rgba(0, 0, 0, 0.01) 25%, rgba(0, 0, 0, 0.01) 2%, #1f2226 116%);
}
</style>
