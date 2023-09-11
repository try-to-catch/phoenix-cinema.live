<script lang="ts" setup>
import SeatCard from '@/Components/Screenings/SeatCard.vue'
import type { ISeat } from '@/types/seats/ISeat'
import { SeatType } from '@/types/seats/ISeat'
import { computed, toRefs } from 'vue'

const props = defineProps<{
  seatingPlan: readonly ISeat[][]
  selectedSeats: Readonly<ISeat>[]
}>()
const { seatingPlan, selectedSeats } = toRefs(props)

const emit = defineEmits<{
  selectSeat: [value: ISeat]
  unselectSeat: [value: ISeat]
}>()

type formattedSeat = Readonly<ISeat> & {
  classes: string
  title: string
  is_selected: boolean
}

const updateSelectedSeats = (seat: formattedSeat) => {
  if (seat.is_taken) return

  if (seat.is_selected) {
    emit('unselectSeat', seat)
  } else {
    emit('selectSeat', seat)
  }
}

const formattedSeatPlan = computed(() => {
  return seatingPlan.value.map(seatRow => {
    return seatRow.map(seat => {
      const isSelected = selectedSeats.value.some(selectedSeat => selectedSeat.id === seat.id)

      let classes = 'cursor-pointer border duration-300 ease-in-out '
      if (isSelected && seat.type === SeatType.Standard) {
        classes += 'border-blue-400 bg-blue-400'
      } else if (seat.is_taken) {
        classes +=
          "border-white after:content-['×'] after:text-white relative after:translate-x-1/2 after:absolute after:right-1/2 hover:after:duration-300 "
        if (seat.type === SeatType.Standard) {
          classes += 'hover:border-blue-400 hover:after:text-blue-400 hover'
        } else if (seat.type === SeatType.Premium) {
          classes += 'hover:border-secondary hover:after:text-secondary'
        }
      } else if (isSelected && seat.type === SeatType.Premium) {
        classes += 'border-secondary bg-secondary'
      } else if (seat.type === SeatType.Standard) {
        classes += 'border-blue-400 hover:bg-blue-400 hover:bg-opacity-20'
      } else if (seat.type === SeatType.Premium) {
        classes += 'border-secondary hover:bg-secondary hover:bg-opacity-20'
      }

      let title = ''
      if (seat.is_taken) {
        title = 'Це місце зайнято'
      } else if (seat.type !== SeatType.Blank) {
        title = `${seat.row_number} ряд, ${seat.seat_number} місце`
      }

      return {
        ...seat,
        title,
        classes,
        is_selected: isSelected,
      }
    })
  })
})
</script>

<template>
  <div class="w-fit flex flex-col space-y-1.5">
    <div v-for="(seatRow, id) in formattedSeatPlan" :key="id" class="flex justify-center space-x-1.5">
      <SeatCard
        v-for="seat in seatRow"
        :key="seat.id"
        :class="seat.classes"
        :title="seat.title"
        @click="updateSelectedSeats(seat)"
      />
    </div>
  </div>
</template>
