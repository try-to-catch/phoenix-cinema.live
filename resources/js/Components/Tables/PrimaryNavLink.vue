<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

defineProps<{ routeName: string }>()
</script>

<template>
  <Link
    :href="route(routeName)"
    class="sm:py-2 py-1 sm:text-sm text-xs text-white border border-neutral-800 rounded-lg sm:px-6 px-3 bg-primary text-center flex items-center justify-center hover:border-secondary duration-300"
  >
    <slot />
  </Link>
</template>
