<script setup lang="ts">
defineProps<{ title: string }>()
</script>

<template>
    <li class="w-full h-full bg-tertiary rounded-md p-10 border border-gray-800 relative hover:border-secondary duration-500 cursor-pointer">
        <h5 class="md:text-xl text-lg font-medium uppercase">{{ title }}</h5>

        <p class="text-sm sm:text-base mt-2 font-sans">
            <slot name="text"/>
        </p>

        <slot name="emoji"/>
    </li>
</template>

