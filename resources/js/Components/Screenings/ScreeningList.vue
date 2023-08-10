<script lang="ts" setup>
import ArrowRight from "@/Components/Icons/ArrowRight.vue";
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";

const sliderRef = ref<HTMLUListElement | null>(null)

const scrollStep = 320
const onWheelScroll = (event: WheelEvent) => {
  if (!sliderRef.value) return

  let newScrollLeft = 0
  const sliderLeft = sliderRef.value.scrollLeft

  if (event.deltaY > 0) {
    newScrollLeft = sliderLeft + scrollStep / 3
  } else if (event.deltaY < 0) {
    newScrollLeft = sliderLeft - scrollStep / 3
  }

  sliderRef.value.scrollLeft = newScrollLeft
  updateArrowsVisibility(newScrollLeft)
}

const updateScrollLeft = (value: number) => {
  if (sliderRef.value) {
    const newScrollLeft = sliderRef.value.scrollLeft + value
    sliderRef.value.scrollLeft = newScrollLeft
    updateArrowsVisibility(newScrollLeft)
  }
}

const isRightArrowVisible = ref(true)
const isLeftArrowVisible = ref(false)

const updateArrowsVisibility = (currentScrollLeft: number) => {
  if (sliderRef.value) {
    const slider = sliderRef.value

    isRightArrowVisible.value = Math.round(currentScrollLeft) + slider.clientWidth < slider.scrollWidth
    isLeftArrowVisible.value = currentScrollLeft > 0
  }
}

const activeScreeningDay = ref(0)

const updateActiveScreeningDay = (id: number) => {
  activeScreeningDay.value = id
}

const mockScreeningList = [
  {date: 'Сьогодні', screenings: ['10:00', '12:00', '14:00', '16:00', '18:00']},
  {date: 'Завтра', screenings: ['10:30', '12:50', '14:20', '16:40',]},
  {date: '23.03', screenings: ['10:30', '12:50', '14:20', '16:40', '18:40', '20:50']},
  {date: '24.03', screenings: ['10:00', '16:00', '18:00', '20:00']},
  {date: '25.03', screenings: ['10:00', '12:00', '14:00', '16:00', '18:00', '20:00']},
  {date: '26.03', screenings: ['10:00', '12:00', '14:00', '16:00', '20:00']},
  {date: '27.03', screenings: ['10:00', '12:00', '14:00', '16:00', '18:00', '20:00']},
  {date: '28.03', screenings: ['10:00', '12:00', '14:00', '16:00', '18:00', '20:00']},
  {date: '29.03', screenings: ['10:00', '12:00', '14:00', '18:00', '20:00']},
  {date: '30.03', screenings: ['14:00', '16:00', '18:00', '20:00']},
  {date: '01.04', screenings: ['10:00', '16:00', '18:00', '20:00']},
  {date: '02.04', screenings: ['10:00', '12:00', '14:00', '16:00',]},

]
</script>

<template>
  <div class="">
    <div class="min-w-full relative">
      <div ref="sliderRef"
           class="overflow-x-auto lg:overflow-hidden z-10 scroll-smooth  border border-secondary rounded-md"
           @wheel="onWheelScroll">
        <ul class="flex md:h-10 h-8 w-fit slider scroll-m-10 font-sans">
          <li v-for="(screeningDay, id) in mockScreeningList"
              :class="{
                        'bg-secondary-75 text-secondary font-bold backdrop-opacity-10': activeScreeningDay === id,
                        'text-secondary bg-tertiary md:hover:text-lg hover:text-base font-medium': activeScreeningDay !== id
                    }"
              class="h-full flex items-center justify-center md:w-[160px] sm:w-[140px] w-[120px] md:text-base text-sm cursor-pointer relative border-x border-secondary duration-300"
              @click="updateActiveScreeningDay(id)">
            {{ screeningDay.date }}
          </li>
        </ul>
      </div>

      <div v-if="isLeftArrowVisible"
           class="hidden lg:block absolute top-1/2 transform -translate-y-1/2 -left-12 p-3 w-fit rotate-180 border border-secondary rounded-md"
           role="button"
           @click="updateScrollLeft(-scrollStep)">
        <ArrowRight class="fill-secondary"/>
      </div>

      <div v-if="isRightArrowVisible"
           class="hidden lg:block absolute top-1/2 transform -translate-y-1/2 -right-12 p-3 w-fit border border-secondary rounded-md"
           role="button"
           @click="updateScrollLeft(scrollStep)">
        <ArrowRight class="fill-secondary"/>
      </div>
    </div>

    <div class="w-full mt-6">
      <ul class="grid lg:grid-cols-12 md:grid-cols-10 sm:grid-cols-8 grid-cols-6 gap-1.5">
        <li v-for="screening in mockScreeningList[activeScreeningDay].screenings"
            class="text-center md:py-2 py-1.5 bg-tertiary text-secondary font-medium rounded-lg border border-secondary hover-bg-secondary-75 duration-300 md:text-base text-sm">
          <Link href="#">
            {{ screening }}
          </Link>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
.bg-secondary-75 {
  background-color: rgba(243, 117, 21, 0.075);
}

.hover-bg-secondary-75:hover {
  background-color: rgba(243, 117, 21, 0.075);
}
</style>