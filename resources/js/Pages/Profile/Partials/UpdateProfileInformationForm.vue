<script lang="ts" setup>
import InputError from '@/Components/Breeze/InputError.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import TextInput from '@/Components/Breeze/TextInput.vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'

defineProps<{
  mustVerifyEmail?: boolean
  status?: string
}>()

const user = usePage().props.auth.user

const form = useForm({
  name: user.name,
  email: user.email,
})
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-white">Інформація профілю</h2>

      <p class="mt-1 text-sm text-neutral-400">Оновіть інформацію про профіль акаунта та адресу електронної пошти.</p>
    </header>

    <form class="mt-6 space-y-6" @submit.prevent="form.patch(route('profile.update'))">
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

      <div>
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

      <div v-if="mustVerifyEmail && user.email_verified_at === null">
        <p class="text-sm mt-2 text-neutral-200">
          Ваша електронна адреса не підтверджена.
          <Link
            :href="route('verification.send')"
            as="button"
            class="underline text-sm text-neutral-500 hover:text-neutral-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary"
            method="post"
          >
            Натисніть тут, щоб повторно надіслати лист з підтвердженням.
          </Link>
        </p>

        <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600">
          На вашу електронну адресу надіслано нове посилання для підтвердження.
        </div>
      </div>

      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing"> Зберегти </PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-neutral-400">Збережено.</p>
        </Transition>
      </div>
    </form>
  </section>
</template>
