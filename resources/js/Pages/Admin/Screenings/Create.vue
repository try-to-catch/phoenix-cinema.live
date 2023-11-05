<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import PrimaryNavLink from '@/Components/Tables/PrimaryNavLink.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import { IMovieTitleAndId } from '@/types/movies/IMovieTitleAndId'
import { IHall } from '@/types/hall/IHall'
import { INewScreening } from '@/types/screenings/INewScreening'
import SelectInput from '@/Components/Forms/SelectInput.vue'

defineProps<{
  movies: Readonly<IMovieTitleAndId>[]
  hallTemplates: Readonly<IHall[]>
}>()
const form = useForm<INewScreening>({
  movie_id: null,
  hall_template_id: null,
  start_time: '',
  end_time: '',
  standard_seat_price: 0,
  premium_seat_price: 0,
})

const submitForm = () => {
  form.post(route('admin.hall_templates.store'))
}
</script>

<template>
  <Head title="Фільми" />
  <AdminLayout :is-wide="false">
    <div class="py-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <div class="flex justify-between items-center">
              <h2 class="sm:text-lg text-base font-medium text-white">Створення залу</h2>

              <PrimaryNavLink route-name="admin.movies.index">Повернутися</PrimaryNavLink>
            </div>
            <div>
              <form class="mt-4 space-y-3" @submit.prevent="submitForm">
                <div class="">
                  <SelectInput />
                </div>
                <PrimaryButton type="submit">Створити</PrimaryButton>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped></style>
