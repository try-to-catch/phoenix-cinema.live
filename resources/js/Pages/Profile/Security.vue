<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/ProfileLayout.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Профіль" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
          <UpdatePasswordForm class="max-w-xl" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
