<script lang="ts" setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/Breeze/InputError.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import TextInput from '@/Components/Breeze/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('register'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation')
    },
  })
}
</script>

<template>
  <GuestLayout>
    <Head><title>Реєстрація</title></Head>

    <h1 class="text-xl font-bold leading-tight tracking-tight text-white mb-4">
      Зареєструйте для безкоштовного акаунта
    </h1>

    <form @submit.prevent="submit">
      <div>
        <TextInput
          id="name"
          v-model="form.name"
          autocomplete="name"
          autofocus
          class="mt-1 block w-full"
          label-inner="Ім'я"
          required
          type="text"
        />

        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <div class="mt-4">
        <TextInput
          id="email"
          v-model="form.email"
          autocomplete="username"
          class="mt-1 block w-full"
          label-inner="Ел. адреса"
          required
          type="email"
        />

        <InputError :message="form.errors.email" class="mt-2" />
      </div>

      <div class="mt-4">
        <TextInput
          id="password"
          v-model="form.password"
          autocomplete="new-password"
          class="mt-1 block w-full"
          label-inner="Пароль"
          required
          type="password"
        />

        <InputError :message="form.errors.password" class="mt-2" />
      </div>

      <div class="mt-4">
        <TextInput
          id="password_confirmation"
          v-model="form.password_confirmation"
          autocomplete="new-password"
          class="mt-1 block w-full"
          label-inner="Підтвердіть пароль"
          required
          type="password"
        />

        <InputError :message="form.errors.password_confirmation" class="mt-2" />
      </div>

      <div class="my-4">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Зареєструватися
        </PrimaryButton>
      </div>

      <div class="text-sm font-light text-neutral-500">
        Вже маєте акаунт?
        <Link :href="route('login')" class="font-medium text-secondary hover:underline"> Увійти </Link>
      </div>
    </form>
  </GuestLayout>
</template>
