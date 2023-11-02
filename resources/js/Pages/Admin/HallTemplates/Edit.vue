<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import PrimaryNavLink from '@/Components/Tables/PrimaryNavLink.vue'
import TextInput from '@/Components/Breeze/TextInput.vue'
import InputError from '@/Components/Breeze/InputError.vue'
import NumberInput from '@/Components/Breeze/NumberInput.vue'
import Checkbox from '@/Components/Breeze/Checkbox.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import NewSeatPlan from '@/Components/Screenings/NewSeatPlan.vue'
import type { IHallTemplate } from '@/types/hallTemplates/IHallTemplate'
import type { INewHallTemplate } from '@/types/hallTemplates/INewHallTemplate'

const { hallTemplate } = defineProps<{ hallTemplate: IHallTemplate }>()

const form = useForm<INewHallTemplate>({
  number: hallTemplate.number,
  address: hallTemplate.address,
  is_available: hallTemplate.is_available,
  seats: [...hallTemplate.seats],
})

const submitForm = () => {
  form.put(route('admin.hall_templates.update', { hall_template: hallTemplate.id }))
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
              <h2 class="sm:text-lg text-base font-medium text-white">Редагування залу</h2>
              <PrimaryNavLink route-name="admin.movies.index">Повернутися</PrimaryNavLink>
            </div>
            <div>
              <form class="mt-4 space-y-3" @submit.prevent="submitForm">
                <div class="flex space-x-1.5 w-full">
                  <div class="grow">
                    <TextInput
                      id="address"
                      v-model="form.address"
                      label-inner="Адреса"
                      type="text"
                      required
                      autocomplete="address"
                    />
                  </div>

                  <div class="sm:w-[15%] w-1/5">
                    <NumberInput
                      id="number"
                      v-model.number="form.number"
                      label-inner="Номер"
                      required
                      :max="100"
                      :min="0"
                    />
                  </div>
                  <InputError :message="form.errors.number" class="mt-1.5" />
                  <InputError :message="form.errors.address" class="mt-1.5" />
                </div>

                <div class="p-5 pb-0">
                  <NewSeatPlan v-model="form.seats" />
                </div>

                <div>
                  <label class="flex items-center">
                    <Checkbox v-model:checked="form.is_available" name="remember" />
                    <span class="ml-2 text-sm text-neutral-400"> Доступно для показу сеансів? </span>
                  </label>
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
