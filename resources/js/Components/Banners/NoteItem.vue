<script setup lang="ts">
defineProps<{ title: string }>()
</script>

<template>
    <li>
        <span class="font-semibold mr-1">{{ title }}</span>
        <span class="font-sans"><slot/></span>
    </li>
</template>
