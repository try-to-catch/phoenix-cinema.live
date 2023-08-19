<script setup lang="ts">
import Checkbox from '@/Components/Breeze/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Breeze/InputError.vue';
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue';
import TextInput from '@/Components/Breeze/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

defineProps<{
  canResetPassword?: boolean;
  status?: string;
}>();

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => {
      form.reset('password');
    },
  });
};
</script>

<template>
  <GuestLayout>
    <Head><title>Log in</title>
      <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    </Head>

    <h1 class="text-xl font-bold leading-tight tracking-tight text-white mb-4">
      Sign in to your account
    </h1>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <TextInput
            label-inner="Email"
            id="email"
            type="email"
            styles="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
        />

        <InputError class="mt-2" :message="form.errors.email"/>
      </div>

      <div class="mt-4">
        <TextInput
            label-inner="Password"
            id="password"
            type="password"
            styles="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="current-password"
        />

        <InputError class="mt-2" :message="form.errors.password"/>
      </div>

      <div class="flex items-center justify-between mt-4">
        <div>
          <label class="flex items-center">
            <Checkbox name="remember" v-model:checked="form.remember"/>
            <span class="ml-2 text-sm text-neutral-500">Remember me</span>
          </label>
        </div>


        <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="text-sm font-medium text-neutral-400 hover:underline"
        >
          Forgot your password?
        </Link>
      </div>

      <div class="my-4">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Log in
        </PrimaryButton>
      </div>

      <div class="text-sm font-light text-neutral-500">
        Don’t have an account yet?
        <Link :href="route('register')" class="font-medium text-secondary hover:underline">Sign up</Link>
      </div>
    </form>
  </GuestLayout>
</template>
