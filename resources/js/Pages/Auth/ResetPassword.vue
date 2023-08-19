<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Breeze/InputError.vue';
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue';
import TextInput from '@/Components/Breeze/TextInput.vue';
import {Head, useForm} from '@inertiajs/vue3';

const props = defineProps<{
  email: string;
  token: string;
}>();

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation');
    },
  });
};
</script>

<template>
  <GuestLayout>
    <Head><title>Reset Password</title></Head>

    <form @submit.prevent="submit">
      <div>
        <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
            label-inner="Email"/>

        <InputError class="mt-2" :message="form.errors.email"/>
      </div>

      <div class="mt-4">
        <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="new-password"
            label-inner="Password"/>

        <InputError class="mt-2" :message="form.errors.password"/>
      </div>

      <div class="mt-4">

        <TextInput
            id="password_confirmation"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
            label-inner="Confirm Password"/>

        <InputError class="mt-2" :message="form.errors.password_confirmation"/>
      </div>

      <div class="flex items-center justify-end mt-4">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Reset Password
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
