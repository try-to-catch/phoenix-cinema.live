<script lang="ts" setup>
import type { IOrderWithScreening } from '@/types/profile/orders/IOrderWithScreening'
import ProfileOrderItem from '@/Components/Orders/ProfileOrderItem.vue'

defineProps<{ orders: IOrderWithScreening[] }>()
</script>

<template>
  <ul class="flex flex-col space-y-2 text-white w-full">
    <ProfileOrderItem
      v-for="order in orders"
      :id="order.id"
      :key="order.id"
      :is-completed="order.isCompleted"
      :screening="order.screening"
      :seats-count="order.seatsCount"
      :show-date="order.showDate"
    />
  </ul>
</template>

<style scoped></style>
