<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import PrimaryNavLink from '@/Components/Tables/PrimaryNavLink.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import SelectInput from '@/Components/Forms/SelectInput.vue'
import InputError from '@/Components/Breeze/InputError.vue'
import NumberInput from '@/Components/Breeze/NumberInput.vue'
import DateTimeInput from '@/Components/Forms/DateTimeInput.vue'
import type { IMovieTitleAndId } from '@/types/movies/IMovieTitleAndId'
import type { INewScreening } from '@/types/screenings/INewScreening'
import type { IHall } from '@/types/hall/IHall'
import type { IOption } from '@/types/forms/IOption'

defineProps<{
  movies: Readonly<IMovieTitleAndId>[]
  hallTemplates: Readonly<IHall>[]
}>()

const form = useForm<INewScreening>({
  movie_id: null,
  hall_template_id: null,
  start_time: '',
  standard_seat_price: 0,
  premium_seat_price: 0,
})

const submitForm = () => {
  form.post(route('admin.screenings.store'))
}
</script>

<template>
  <Head title="Покази" />
  <AdminLayout :is-wide="false">
    <div class="py-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <div class="flex justify-between items-center">
              <h2 class="sm:text-lg text-base font-medium text-white">Створення залу</h2>

              <PrimaryNavLink route-name="admin.movies.screenings.index">Повернутися</PrimaryNavLink>
            </div>
            <div>
              <form class="mt-4 space-y-3" @submit.prevent="submitForm">
                <div class="grid sm:grid-cols-2 gap-2.5">
                  <div>
                    <SelectInput
                      v-model="form.movie_id"
                      :items="movies"
                      search-key="title"
                      placeholder="Виберіть фільм"
                    />
                    <InputError :message="form.errors.movie_id" class="mt-1.5" />
                  </div>
                  <div>
                    <SelectInput
                      v-slot="{ option }: { option: IOption }"
                      v-model="form.hall_template_id"
                      :items="hallTemplates"
                      search-key="address"
                      placeholder="Виберіть зал"
                    >
                      {{ option.address }} #{{ option.number }}
                    </SelectInput>
                    <InputError :message="form.errors.hall_template_id" class="mt-1.5" />
                  </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-2.5">
                  <div>
                    <NumberInput
                      id="standard_seat_price"
                      v-model="form.standard_seat_price"
                      label-inner="Ціна за стандартне місце"
                      required
                      :max="2000"
                    />
                    <InputError :message="form.errors.standard_seat_price" class="mt-1.5" />
                  </div>

                  <div>
                    <NumberInput
                      id="premium_seat_price"
                      v-model="form.premium_seat_price"
                      label-inner="Ціна за преміум місце"
                      required
                      :max="2000"
                    />
                    <InputError :message="form.errors.premium_seat_price" class="mt-1.5" />
                  </div>
                </div>

                <div>
                  <DateTimeInput id="start_time" v-model="form.start_time" label-inner="Початок показу" required />
                  <InputError :message="form.errors.start_time" class="mt-1.5" />
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
