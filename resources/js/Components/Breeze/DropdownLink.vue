<script lang="ts" setup>
import { Link } from '@inertiajs/vue3'

defineProps<{
  href: string
}>()
</script>

<template>
  <Link
    :href="href"
    class="block w-full px-4 py-2 text-left text-sm leading-5 text-white hover:bg-neutral-800 focus:outline-none transition duration-150 ease-in-out"
  >
    <slot />
  </Link>
</template>
