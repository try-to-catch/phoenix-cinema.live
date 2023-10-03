<script lang="ts" setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue'
import { Head } from '@inertiajs/vue3'
import type { IPaginatedOrderWithScreening } from '@/types/profile/orders/IPaginatedOrderWithScreening'
import ProfileOrderList from '@/Components/Orders/ProfileOrderList.vue'
import Pagination from '@/Components/Shared/Pagination.vue'

const { orders } = defineProps<{ orders: IPaginatedOrderWithScreening }>()
</script>

<template>
  <Head title="Мої замовлення" />
  <ProfileLayout>
    <div class="py-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <div>
              <h2 class="text-lg font-medium text-white pl-5">Мої замовлення</h2>
            </div>

            <div class="mt-6 flex flex-col items-center space-y-4">
              <ProfileOrderList :orders="orders.data" />
              <Pagination :links="orders.meta.links" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </ProfileLayout>
</template>

<style scoped></style>
