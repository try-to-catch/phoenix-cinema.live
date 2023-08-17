<script lang="ts" setup>

defineProps<{
    topText: string;
    bottomText: string;
    reverseOnMobile?: boolean;
}>()
</script>

<template>
    <div class="flex items-center lg:border lg:border-neutral-700 rounded-md overflow-hidden">
        <div class="lg:w-[60px] h-full flex justify-center items-center">
            <slot/>
        </div>
        <div :class="{'sm:flex-row-reverse space-x-reverse flex-col': reverseOnMobile}"
             class="flex items-baseline lg:flex-col lg:items-center text-white py-1 sm:py-2 md:py-3 sm:px-5 px-3 space-y-0.5 lg:bg-tertiary space-x-2 lg:space-x-0 text-xs sm:text-sm">
            <div class="font-medium text-white lg:text-neutral-400 lg:font-light">{{ topText }}</div>
            <div class="font-medium text-white">{{ bottomText }}</div>
        </div>
    </div>
</template>

<style scoped>

</style>
