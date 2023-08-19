<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Breeze/InputError.vue';
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue';
import TextInput from '@/Components/Breeze/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation');
    },
  });
};
</script>

<template>
  <GuestLayout>
    <Head><title>Register</title></Head>

    <h1 class="text-xl font-bold leading-tight tracking-tight text-white mb-4">
      Sign up for a free account
    </h1>


    <form @submit.prevent="submit">
      <div>
        <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
            label-inner="Name"/>

        <InputError class="mt-2" :message="form.errors.name"/>
      </div>

      <div class="mt-4">
        <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
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

      <div class="my-4">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Register
        </PrimaryButton>
      </div>

      <div class="text-sm font-light text-neutral-500">
        Already have an account?
        <Link :href="route('login')" class="font-medium text-secondary hover:underline">Sign in</Link>
      </div>
    </form>
  </GuestLayout>
</template>
