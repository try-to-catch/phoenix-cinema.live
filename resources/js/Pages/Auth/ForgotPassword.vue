<script lang="ts" setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/Breeze/InputError.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import TextInput from '@/Components/Breeze/TextInput.vue'
import { Head, useForm } from '@inertiajs/vue3'

defineProps<{
  status?: string
}>()

const form = useForm({
  email: '',
})

const submit = () => {
  form.post(route('password.email'))
}
</script>

<template>
  <GuestLayout>
    <Head><title>Забув пароль</title></Head>

    <div class="mb-4 text-sm text-neutral-600">
      Забули пароль? Нічого страшного. Просто повідомте нам свою електронну адресу, і ми надішлемо вам посилання для
      скидання пароля за яким ви зможете обрати новий.
    </div>

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
          class="mt-1 block w-full"
          label-inner="Ел. адреса"
          required
          type="email"
        />

        <InputError :message="form.errors.email" class="mt-2" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Отримати посилання
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
