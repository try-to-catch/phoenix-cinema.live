<script setup lang="ts">
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps<{
  href: string;
  active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:bg-tertiary hover:border-secondary focus:outline-none focus:text-secondary transition duration-300 ease-in-out'
);
</script>

<template>
  <Link :href="href" :class="classes">
    <slot/>
  </Link>
</template>
