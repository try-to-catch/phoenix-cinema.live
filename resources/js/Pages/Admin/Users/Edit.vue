<script setup lang="ts">
import { computed } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import PrimaryNavLink from '@/Components/Tables/PrimaryNavLink.vue'
import Checkbox from '@/Components/Breeze/Checkbox.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import TextInput from '@/Components/Breeze/TextInput.vue'
import { RoleName } from '@/types/roles/RoleName'
import type { IUserEditForm } from '@/types/users/IUserEditForm'
import type { IUser } from '@/types/users/IUser'

const { user } = defineProps<{ readonly user: Readonly<IUser> }>()

const form = useForm<IUserEditForm>({
  roles: [...user.roles],
  _method: 'put',
})

const submitForm = () => {
  form.post(route('admin.users.update', user.id))
}

const formattedRoles = computed(() => {
  return Object.values(RoleName).map(role => {
    return {
      name: role,
      checked: form.roles.includes(role),
    }
  })
})

const syncRoles = (isChecked: boolean, role: RoleName) => {
  if (isChecked) {
    form.roles.push(role)
  } else {
    form.roles = form.roles.filter(r => r !== role)
  }
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
              <h2 class="sm:text-lg text-base font-medium text-white">Редагування ролей</h2>

              <PrimaryNavLink route-name="admin.movies.index">Повернутися</PrimaryNavLink>
            </div>

            <div class="-mx-1.5">
              <form class="mt-4 space-y-3" @submit.prevent="submitForm">
                <div class="grid sm:grid-cols-2 gap-3">
                  <TextInput id="name" :model-value="user.name" disabled label-inner="Name" type="text" required />
                  <TextInput id="email" :model-value="user.email" disabled label-inner="Email" type="email" required />
                </div>

                <div class="text-neutral-500 text-sm">
                  <p>Касир(cashier) може сзчитувати QR-коди білетів. Не має доступа до адмінки.</p>
                  <p>Редактор(editor) може маніпалювати фільмами, показами та залами.</p>
                  <p>Адмін(admin) може все те що інші ролі, а також маніпалювати ролями користувачів.</p>
                </div>
                {{ form.errors.roles }}
                <div class="flex space-x-1.5">
                  <label v-for="role in formattedRoles" :key="role.name" class="flex items-center">
                    <Checkbox :checked="role.checked" @update:checked="val => syncRoles(val, role.name)" />
                    <span class="ml-2 text-sm text-neutral-400"> {{ role.name }} </span>
                  </label>
                </div>

                <PrimaryButton type="submit"> Оновити</PrimaryButton>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped></style>
