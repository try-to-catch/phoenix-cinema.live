<script lang="ts" setup>
import SeatCard from '@/Components/Screenings/SeatCard.vue'
import { SeatType } from '@/types/seats/ISeat'
import { computed, toRef, watch } from 'vue'
import type { ISeatType } from '@/types/seats/ISeatType'
import AddSeatCard from '@/Components/Screenings/AddSeatCard.vue'

const props = defineProps<{
  modelValue: ISeatType[][]
}>()

const newSeatPlan = toRef(props, 'modelValue')

const emit = defineEmits<{
  'update:modelValue': [value: ISeatType[][]]
}>()

watch(newSeatPlan, () => {
  emit('update:modelValue', newSeatPlan.value)
})

const updateSeatTypeOrRemove = (row: number, column: number) => {
  const seat = newSeatPlan.value[row][column]

  if (seat.type === SeatType.Standard) {
    newSeatPlan.value[row][column] = { type: SeatType.Premium }
  } else if (seat.type === SeatType.Premium) {
    newSeatPlan.value[row][column] = { type: SeatType.Blank }
  } else if (seat.type === SeatType.Blank) {
    newSeatPlan.value[row][column] = { type: SeatType.Standard }
  }
}

const removeSeat = (row: number, column: number) => {
  if (newSeatPlan.value[row].length === 1) {
    newSeatPlan.value.splice(row, 1)
    return
  }

  newSeatPlan.value[row].splice(column, 1)
}

const NEW_ITEM = { type: SeatType.Standard }
const addNewSeat = (row: number, toEnd: boolean) => {
  if (toEnd) {
    newSeatPlan.value[row].push(NEW_ITEM)
    return
  }

  newSeatPlan.value[row].unshift(NEW_ITEM)
}

const addNewSeatRow = (toBottom: boolean) => {
  const newSeatPlanLength = newSeatPlan.value.length

  if (newSeatPlanLength === 0) {
    newSeatPlan.value.push([NEW_ITEM])
    return
  }

  if (toBottom) {
    newSeatPlan.value.push([...newSeatPlan.value[newSeatPlanLength - 1]])
    return
  }

  newSeatPlan.value.unshift([...newSeatPlan.value[0].slice()])
}

const formattedSeatPlan = computed(() => {
  return newSeatPlan.value.map(seatRow => {
    return seatRow.map(seat => {
      let classes = 'cursor-pointer border duration-300 ease-in-out '
      if (seat.type === SeatType.Standard) {
        classes += 'border-blue-400 hover:bg-blue-400 hover:bg-opacity-20'
      } else if (seat.type === SeatType.Premium) {
        classes += 'border-secondary hover:bg-secondary hover:bg-opacity-20'
      } else {
        classes = 'opacity-0'
      }

      return {
        ...seat,
        classes,
      }
    })
  })
})
</script>

<template>
  <div class="flex flex-col items-center" @click.right.prevent>
    <div class="w-fit flex flex-col space-y-1">
      <AddSeatCard :is-width-fixed="false" @click="addNewSeatRow(false)" />
      <div
        v-for="(seatRow, rowIndex) in formattedSeatPlan"
        :key="rowIndex"
        class="flex justify-center items-center space-x-1.5"
      >
        <AddSeatCard @click="addNewSeat(rowIndex, false)" />
        <SeatCard
          v-for="(seat, columnIndex) in seatRow"
          :key="columnIndex"
          :class="seat.classes"
          @click="updateSeatTypeOrRemove(rowIndex, columnIndex)"
          @click.right="removeSeat(rowIndex, columnIndex)"
        />
        <AddSeatCard @click="addNewSeat(rowIndex, true)" />
      </div>
      <AddSeatCard v-if="newSeatPlan.length !== 0" :is-width-fixed="false" @click="addNewSeatRow(true)" />
    </div>

    <div class="sm:flex hidden flex-wrap items-center space-x-1.5 mt-5">
      <div
        class="bg-neutral-400 bg-opacity-50 text-tertiary rounded-full h-4 w-4 font-bold flex items-center justify-center text-xs italic"
      >
        <span>i</span>
      </div>
      <p class="text-gray-300 flex flex-wrap items-center text-xs">
        Стани: стандарт
        <SeatCard class="border border-blue-400 hover:bg-blue-400 hover:bg-opacity-20 mx-1" />/ преміум
        <SeatCard class="border border-secondary hover:bg-secondary hover:bg-opacity-20 mx-1" />/ бланк(invisible)
        <SeatCard class="border opacity-0 mx-1" />
        / видалений(right click)
      </p>
    </div>
  </div>
</template>
