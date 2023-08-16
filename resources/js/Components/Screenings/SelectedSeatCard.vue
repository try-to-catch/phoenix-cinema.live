<script setup lang="ts">

import XMark from "@/Components/Icons/XMark.vue";

defineProps<{
    row: number,
    seat: number,
    price: number,
    type: string
}>()

const emit = defineEmits<{ (e: 'remove'): void }>()
</script>

<template>
    <div
        class="w-full bg-tertiary py-4 pl-5 pr-12 flex border border-neutral-700 rounded-md justify-between items-center relative">
        <div class="flex space-x-4">
            <div class="text-center">
                <div class="text-xl text-white font-medium">{{ row }}</div>
                <div class="text-sm text-white font-light">ряд</div>
            </div>
            <div class="text-center">
                <div class="text-xl text-white font-medium">{{ seat }}</div>
                <div class="text-sm text-white font-light">місце</div>
            </div>
        </div>

        <div>
            <div class="text-secondary font-semibold">
                <span class="text-xl">{{ price }}</span> <small class="text-xs">грн</small>
            </div>

            <div class="text-[0.625rem] text-neutral-400">тип <span class="font-medium">{{ type }}</span></div>
        </div>

        <div @click="emit('remove')"
             class="absolute right-2 cursor-pointer fill-neutral-400 hover:fill-secondary duration-300">
            <XMark class="h-6 w-6"/>
        </div>
    </div>
</template>
