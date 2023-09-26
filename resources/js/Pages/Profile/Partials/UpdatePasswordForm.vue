<script lang="ts" setup>
import InputError from '@/Components/Breeze/InputError.vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import TextInput from '@/Components/Breeze/TextInput.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const passwordInput = ref<HTMLInputElement | null>(null)
const currentPasswordInput = ref<HTMLInputElement | null>(null)

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

const updatePassword = () => {
  form.put(route('password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
    onError: () => {
      if (form.errors.password) {
        form.reset('password', 'password_confirmation')
        passwordInput.value?.focus()
      }
      if (form.errors.current_password) {
        form.reset('current_password')
        currentPasswordInput.value?.focus()
      }
    },
  })
}
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-white">Оновити пароль</h2>

      <p class="mt-1 text-sm text-neutral-400">
        Переконайтеся, що ваш акаунт використовує довгий випадковий пароль, щоб залишатися в безпеці.
      </p>
    </header>

    <form class="mt-6 space-y-6" @submit.prevent="updatePassword">
      <div>
        <TextInput
          id="current_password"
          ref="currentPasswordInput"
          v-model="form.current_password"
          autocomplete="current-password"
          class="mt-1 block w-full"
          label-inner="Поточний пароль"
          type="password"
        />

        <InputError :message="form.errors.current_password" class="mt-2" />
      </div>

      <div>
        <TextInput
          id="password"
          ref="passwordInput"
          v-model="form.password"
          autocomplete="new-password"
          class="mt-1 block w-full"
          label-inner="Новий пароль"
          type="password"
        />

        <InputError :message="form.errors.password" class="mt-2" />
      </div>

      <div>
        <TextInput
          id="password_confirmation"
          v-model="form.password_confirmation"
          autocomplete="new-password"
          class="mt-1 block w-full"
          label-inner="Підтвердити пароль"
          type="password"
        />

        <InputError :message="form.errors.password_confirmation" class="mt-2" />
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
