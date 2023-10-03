<script lang="ts" setup>
import CheckIcon from '@/Components/Icons/CheckIcon.vue'
import { Link } from '@inertiajs/vue3'
import ClockIcon from '@/Components/Icons/ClockIcon.vue'
import AngleRight from '@/Components/Icons/AngleRight.vue'
import type { IOrderWithScreening } from '@/types/profile/orders/IOrderWithScreening'
import { computed } from 'vue'

const props = defineProps<IOrderWithScreening>()

const seatLabel = computed(() => {
  const lastDigit = props.seatsCount % 10

  if (lastDigit === 1) {
    return 'місце'
  } else if (lastDigit >= 2 && lastDigit <= 4) {
    return 'місця'
  } else {
    return 'місць'
  }
})

const angleRightStyles = computed(() => {
  if (props.isCompleted) {
    return 'text-secondary hover:text-orange-100 hover:bg-secondary'
  } else {
    return 'text-orange-100 hover:text-secondary hover:bg-orange-100'
  }
})
</script>

<template>
  <li class="w-full flex flex-row items-center px-5 py-3 border border-neutral-800 rounded-md">
    <div class="w-full flex flex-col sm:flex-row sm:items-center space-y-1 sm:space-y-0 justify-between">
      <div class="sm:text-base text-sm">
        <Link :href="route('movies.show', { movie: screening.movie.slug })" class="hover:underline">
          {{ screening.movie.title }}
        </Link>
      </div>
      <div class="flex items-center lg:space-x-16 md:space-x-10 space-x-6">
        <div class="flex items-center lg:space-x-10 md:space-x-8 space-x-4">
          <div class="sm:text-base text-sm">{{ seatsCount }} {{ seatLabel }}</div>
          <div class="sm:text-base text-sm">{{ showDate }}</div>
        </div>

        <div v-if="!isCompleted" class="flex items-center space-x-10">
          <div class="md:hidden text-secondary" title="В очікуванні">
            <ClockIcon class="fill-current" />
          </div>
          <div class="md:block hidden bg-orange-100 text-secondary rounded-lg px-2 py-1 text-xs">В очікуванні</div>
        </div>

        <div v-else class="flex items-center space-x-10">
          <div class="md:hidden text-secondary" title="Проглянуто">
            <CheckIcon class="fill-current" />
          </div>
          <div class="md:block hidden bg-orange-600 text-orange-100 rounded-lg px-2 py-1 text-xs">Проглянуто</div>
        </div>
      </div>
    </div>

    <div class="ml-4">
      <a
        :class="angleRightStyles"
        :href="route('orders.preview', { order: id })"
        class="rounded-lg w-6 h-6 flex items-center justify-center duration-300"
      >
        <AngleRight class="fill-current" />
      </a>
    </div>
  </li>
</template>
