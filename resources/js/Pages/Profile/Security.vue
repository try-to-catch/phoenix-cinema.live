<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/ProfileLayout.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Профіль" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <UpdatePasswordForm class="max-w-xl" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
