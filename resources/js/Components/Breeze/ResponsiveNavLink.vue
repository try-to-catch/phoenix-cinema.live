<script lang="ts" setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps<{
  href: string
  active?: boolean
}>()

const classes = computed(() =>
  props.active
    ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-secondary text-left text-base font-medium text-secondary focus:outline-none transition duration-300 ease-in-out'
    : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-white hover:bg-tertiary hover:border-secondary focus:outline-none focus:text-secondary transition duration-300 ease-in-out'
)
</script>

<template>
  <Link :class="classes" :href="href">
    <slot />
  </Link>
</template>
