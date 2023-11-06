<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import PrimaryNavLink from '@/Components/Tables/PrimaryNavLink.vue'
import type { IOrganizedScreening } from '@/types/screenings/IOrganizedScreening'
import ScreeningList from '@/Components/Screenings/ScreeningList.vue'

const { screenings } = defineProps<{ screenings: IOrganizedScreening[] }>()
</script>

<template>
  <Head title="Фільми" />
  <AdminLayout :is-wide="false">
    <div class="py-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <div class="flex justify-between items-center">
              <h2 class="sm:text-lg text-base font-medium text-white">Список показів</h2>
              <PrimaryNavLink route-name="admin.movies.screenings.index">Повернутися</PrimaryNavLink>
            </div>
            <section class="py-8 pb-6 sm:pb-12">
              <div class="lg:container">
                <ScreeningList v-if="screenings.length" :screenings="screenings" link-name="admin.screenings.show" />
                <div v-else class="">
                  <p class="text-white text-xl">Поки що показів не заплановано, слідкуйте за ононсами :3</p>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped></style>
