<script setup lang="ts">
withDefaults(
    defineProps<{
        type?: 'button' | 'submit' | 'reset';
    }>(),
    {
        type: 'button',
    }
);
</script>

<template>
    <button
        :type="type"
        class="w-full px-5 py-2.5 bg-neutral-800 text-white rounded-lg text-sm font-medium shadow-sm hover:bg-neutral-850 focus:outline-none focus:ring-2 focus:ring-secondary disabled:opacity-25 transition ease-in-out duration-300"
    >
        <slot/>
    </button>
</template>
