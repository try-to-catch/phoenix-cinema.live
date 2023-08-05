<script lang="ts" setup>
import {defineProps, ref} from "vue";

defineProps<{ title: string, image_src: string }>()

const isHovered = ref(false)
</script>

<template>
    <li :title="title"
        class="min-w-[218px] w-full flex justify-center min-h-[322px] cursor-pointer relative"
        @mouseover="isHovered =true"
        @mouseleave="isHovered = false"
    >
        <div class="">
            <img :alt="`${title} poster`" :src="image_src" class="rounded-md">

            <div class="w-8 h-8 text-xs absolute rounded-md top-2 left-2 bg-white flex justify-center items-center">
                12+
            </div>

            <transition name="liftUp">
                <div v-if="isHovered"
                     class="absolute bottom-0 w-full h-full rounded-md bg-gradient-to-t from-black to-transparent p-6 flex flex-col justify-end right-[50%] translate-x-1/2">
                    <h6 class="text-sm  text-white font-medium">
                        Джокер повернення додому
                    </h6>

                    <ul class="my-6 space-y-2">
                        <li class="leading-5">
                            <div class="text-xs text-gray-400 mb-1 font-medium">Жанр</div>
                            <div class="text-xs text-white">Інстрія, Фантастика, Драмма</div>
                        </li>
                        <li class="leading-5">
                            <div class="text-xs text-gray-400 mb-1 font-medium">Режисер</div>
                            <div class="text-xs text-white">Крістафер Нолан</div>
                        </li>
                    </ul>

                    <div class="text-xs  text-secondary font-medium">20 липня - 03 серпня</div>
                </div>
            </transition>

        </div>

    </li>
</template>


<style scoped>
.liftUp-enter-active,
.liftUp-leave-active {
    transition: opacity 0.5s ease;
}

.liftUp-enter-from,
.liftUp-leave-to {
    opacity: 0;
}
</style>
