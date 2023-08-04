<script setup lang="ts">

const props = defineProps<{ styles?: string }>()
</script>

<template>
    <div class="text-xl md:text-2xl text-secondary font-semibold"
         :class="[$style['text-shadow'],styles]">
        PHOENIX
    </div>
</template>

<style module>

.text-shadow {
    transition: 0.3s ease-in-out;
}

.text-shadow:hover {
    transition: 0.5s ease-in-out;
    text-shadow: 1px 1px 2px #F37515, 0 0 1em #F37515, 0 0 0.2em #F37515;
}

</style>
