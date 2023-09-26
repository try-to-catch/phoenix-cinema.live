<script lang="ts" setup>
import DangerButton from '@/Components/Breeze/DangerButton.vue'
import InputError from '@/Components/Breeze/InputError.vue'
import Modal from '@/Components/Breeze/Modal.vue'
import SecondaryButton from '@/Components/Breeze/SecondaryButton.vue'
import TextInput from '@/Components/Breeze/TextInput.vue'
import { useForm } from '@inertiajs/vue3'
import { nextTick, ref } from 'vue'

const confirmingUserDeletion = ref(false)
const passwordInput = ref<HTMLInputElement | null>(null)

const form = useForm({
  password: '',
})

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true

  void nextTick(() => passwordInput.value?.focus())
}

const deleteUser = () => {
  form.delete(route('profile.destroy'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value?.focus(),
    onFinish: () => {
      form.reset()
    },
  })
}

const closeModal = () => {
  confirmingUserDeletion.value = false

  form.reset()
}
</script>

<template>
  <section class="space-y-6">
    <header>
      <h2 class="text-lg font-medium text-white">Видалити акаунт</h2>

      <p class="mt-1 text-sm text-neutral-400">
        Після видалення вашого акаунту всі його ресурси та дані будуть безповоротно видалені. Перш ніж видалити свій
        акаунт, будь ласка, завантажте всі дані або інформацію, яку ви хочете зберегти.
      </p>
    </header>

    <DangerButton @click="confirmUserDeletion"> Видалити акаунт </DangerButton>

    <Modal :show="confirmingUserDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-white">Ви впевнені, що хочете видалити свій акаунт?</h2>

        <p class="mt-1 text-sm text-neutral-400">
          Після видалення вашого акаунту всі його ресурси та дані будуть безповоротно видалені. Будь ласка, введіть свій
          пароль, щоб підтвердити, що ви бажаєте остаточно видалити свій акаунт.
        </p>

        <div class="mt-6">
          <TextInput
            id="password"
            ref="passwordInput"
            v-model="form.password"
            class="mt-1 block w-3/4"
            label-inner="Пароль"
            type="password"
            @keyup.enter="deleteUser"
          />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Скасувати </SecondaryButton>

          <DangerButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            class="ml-3"
            @click="deleteUser"
          >
            Видалити акаунт
          </DangerButton>
        </div>
      </div>
    </Modal>
  </section>
</template>
