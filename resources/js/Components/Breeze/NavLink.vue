<script lang="ts" setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps<{
  href: string
  active?: boolean
}>()

const classes = computed(() =>
  props.active
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-secondary text-sm font-medium leading-5 text-secondary focus:outline-none focus:border-secondary transition duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:bg-tertiary hover:border-secondary focus:outline-none focus:text-secondary transition duration-300 ease-in-out'
)
</script>

<template>
  <Link :class="classes" :href="href">
    <slot />
  </Link>
</template>
