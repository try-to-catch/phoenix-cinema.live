<script lang="ts" setup>
import Checkbox from '@/Components/Breeze/Checkbox.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/Breeze/InputError.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import TextInput from '@/Components/Breeze/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

defineProps<{
  canResetPassword?: boolean
  status?: string
}>()

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('login'), {
    onFinish: () => {
      form.reset('password')
    },
  })
}
</script>

<template>
  <GuestLayout>
    <Head>
      <title>Вхід</title>
    </Head>

    <h1 class="text-xl font-bold leading-tight tracking-tight text-white mb-4">Увійдіть до свого акаунту</h1>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <TextInput
          id="email"
          v-model="form.email"
          autocomplete="username"
          autofocus
          label-inner="Ел. адреса"
          required
          styles="mt-1 block w-full"
          type="email"
        />

        <InputError :message="form.errors.email" class="mt-2" />
      </div>

      <div class="mt-4">
        <TextInput
          id="password"
          v-model="form.password"
          autocomplete="current-password"
          label-inner="Пароль"
          required
          styles="mt-1 block w-full"
          type="password"
        />

        <InputError :message="form.errors.password" class="mt-2" />
      </div>

      <div class="flex items-center justify-between mt-4">
        <div>
          <label class="flex items-center">
            <Checkbox v-model:checked="form.remember" name="remember" />
            <span class="ml-2 text-sm text-neutral-500">Запам'ятай мене</span>
          </label>
        </div>

        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="text-sm font-medium text-neutral-400 hover:underline"
        >
          Забули пароль?
        </Link>
      </div>

      <div class="my-4">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Увійти </PrimaryButton>
      </div>

      <div class="text-sm font-light text-neutral-500">
        Ще не маєте акаунта?
        <Link :href="route('register')" class="font-medium text-secondary hover:underline"> Зареєструватися </Link>
      </div>
    </form>
  </GuestLayout>
</template>
