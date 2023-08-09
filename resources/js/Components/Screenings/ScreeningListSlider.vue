<script lang="ts" setup>
import ArrowRight from "@/Components/Icons/ArrowRight.vue";
import {onMounted, ref} from "vue";

const sliderRef = ref<HTMLUListElement | null>(null);

onMounted(() => {
  if (sliderRef.value) {
    console.log(sliderRef.value);

  }
})

const scrollStep = 300;
const onWheelScroll = (event: WheelEvent) => {
  if (event.deltaY > 0) {
    sliderRef.value.scrollLeft += scrollStep / 3;
  } else if (event.deltaY < 0) {
    sliderRef.value.scrollLeft += +scrollStep / 3;
  }
}

const updateScrollLeft = (value: number) => {
  if (sliderRef.value) {
    sliderRef.value.scrollLeft += value;
    console.log(sliderRef.value.scrollLeft);
  }
  console.log(sliderRef.value.scrollLeft);
}
</script>

<template>
  <div class="min-w-full relative">
    <div class="overflow-x-auto lg:overflow-hidden z-10 scroll-smooth" @wheel="onWheelScroll" ref="sliderRef">
      <ul class="flex h-10 border-y border-secondary w-fit slider">
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          Сьогодні
        </li>
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          Завтра
        </li>
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          23.03
        </li>
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          24.03
        </li>
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          25.03
        </li>
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          26.03
        </li>
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          27.03
        </li>
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          28.03
        </li>
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          29.03
        </li>
        <li class="h-full text-secondary bg-tertiary flex items-center justify-center w-[150px] cursor-pointer relative border-x border-secondary">
          30.03
        </li>
      </ul>
    </div>

    <div @click="updateScrollLeft(-scrollStep)"
         class="hidden lg:block absolute top-1/2 transform -translate-y-1/2 -left-12 p-3 w-fit rotate-180 border border-secondary rounded-md"
         role="button">
      <ArrowRight
          class="fill-secondary"/>
    </div>

    <div @click="updateScrollLeft(scrollStep)"
         class="hidden lg:block absolute top-1/2 transform -translate-y-1/2 -right-12 p-3 w-fit border border-secondary rounded-md"
         role="button">
      <ArrowRight
          class="fill-secondary"/>
    </div>
  </div>
</template>

