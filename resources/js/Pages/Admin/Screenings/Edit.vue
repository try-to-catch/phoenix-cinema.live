<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import PrimaryNavLink from '@/Components/Tables/PrimaryNavLink.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import SelectInput from '@/Components/Forms/SelectInput.vue'
import InputError from '@/Components/Breeze/InputError.vue'
import NumberInput from '@/Components/Breeze/NumberInput.vue'
import DateTimeInput from '@/Components/Forms/DateTimeInput.vue'
import type { IScreening } from '@/types/screenings/IScreening'
import type { IScreeningUpdateForm } from '@/types/screenings/IScreeningUpdateForm'
import { watch } from 'vue'

const { screening } = defineProps<{
  screening: Readonly<IScreening>
}>()

const form = useForm<IScreeningUpdateForm>({
  start_time: screening.start_time,
  end_time: screening.end_time,
  standard_seat_price: screening.standard_seat_price,
  premium_seat_price: screening.premium_seat_price,
})

const submitForm = () => {
  form.put(route('admin.screenings.update', screening.id))
}

const calculateDuration = (start: string, end: string) => {
  const startTime = new Date(start)
  const endTime = new Date(end)

  const difference = endTime.getTime() - startTime.getTime()

  return Math.round(difference / 60000)
}

let duration = calculateDuration(screening.start_time, screening.end_time)

watch(
  () => form.start_time,
  newValue => {
    const offset = new Date().getTimezoneOffset()
    form.end_time = new Date(new Date(newValue).getTime() + (duration - offset) * 60000).toISOString().slice(0, 16)
  }
)
</script>

<template>
  <Head title="Покази" />
  <AdminLayout :is-wide="false">
    <div class="py-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <div class="flex justify-between items-center">
              <h2 class="sm:text-lg text-base font-medium text-white">Редагування залу</h2>

              <PrimaryNavLink route-name="admin.movies.screenings.index">Повернутися</PrimaryNavLink>
            </div>
            <div>
              <form class="mt-4 space-y-3" @submit.prevent="submitForm">
                <div class="grid sm:grid-cols-2 gap-2.5">
                  <SelectInput
                    model-value=""
                    :items="[]"
                    search-key="title"
                    :placeholder="screening.movie.title"
                    disabled
                  />

                  <SelectInput
                    model-value=""
                    :items="[]"
                    search-key="address"
                    :placeholder="`${screening.hall.address} #${screening.hall.number}`"
                    disabled
                  />
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

                <div class="grid sm:grid-cols-2 gap-2.5">
                  <div>
                    <DateTimeInput id="start_time" v-model="form.start_time" label-inner="Початок показу" required />
                    <InputError :message="form.errors.start_time" class="mt-1.5" />
                  </div>
                  <div>
                    <DateTimeInput
                      id="end_time"
                      v-model="form.end_time"
                      disabled
                      label-inner="Зікінчення показу"
                      required
                    />
                    <InputError :message="form.errors.end_time" class="mt-1.5" />
                  </div>
                </div>

                <PrimaryButton type="submit">Оновити</PrimaryButton>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped></style>
