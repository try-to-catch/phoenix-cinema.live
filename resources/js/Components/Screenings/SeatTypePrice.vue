<script setup lang="ts">
import SeatCard from '@/Components/Screenings/SeatCard.vue'

defineProps<{ seatColorClass: string; label: string; price: number }>()
</script>

<template>
  <div class="flex space-x-2 items-center font-sans">
    <SeatCard :class="seatColorClass" />
    <div class="sm:text-sm text-xs leading-3 text-white">
      <div class="uppercase">
        {{ label }}
      </div>
      <span>
        <span class="sm:inline hidden">-</span>
        {{ price }} <small>грн</small>
      </span>
    </div>
  </div>
</template>
