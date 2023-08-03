<script setup lang="ts">

import {ref} from "vue";

const activeSlide = ref(0);

const changeActiveSlide = async (id: number) => {
    activeSlide.value = id;

}

</script>

<template>
    <div class="h-[450px] relative scroll-smooth flex overflow-hidden">
        <transition-group name="fade">
            <template v-for="(item, id) in 4">
                <div v-if="activeSlide === id" :key="id"
                     class="bg-[url('/images/defaults/banner.jpg')] bg-center bg-cover w-full h-full bg-no-repeat rounded-xl p-10 flex active"
                >
                    <div class="self-end z-10 text-white details">
                        <h2 class="text-4xl font-semibold">Інтерстайлер{{ id }}</h2>

                        <p class="my-3 line-clamp-2 w-4/5 font-light font-sans">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur et hic
                            id in magni praesentium ratione. Deserunt dolorem enim ipsum iste, maxime minus
                            odit
                            perferendis sint vitae voluptates voluptatibus voluptatum!
                        </p>

                        <div class="flex space-x-4 text-sm">
                            <div class="">з 10.02.2023</div>
                            <div class="">1 г 53 м</div>
                        </div>
                    </div>
                </div>
            </template>

        </transition-group>

        <div class="absolute h-full w-full top-0 ">
            <div class="h-full w-full absolute rounded-[0.58rem] gradient-0"></div>
        </div>

        <ul class="absolute right-3 space-y-4 flex flex-col -translate-y-2/4 top-1/2">
            <li v-for="(item, id) in 4"
                :class="{'bg-tertiary': activeSlide === id, 'bg-gray-200': activeSlide !== id}"
                class="h-2 w-2 rounded-full border border-tertiary cursor-pointer"
                @click="changeActiveSlide(id)"></li>
        </ul>
    </div>
</template>


<style scoped>

.gradient-0 {
    background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.01) 25%, rgba(0, 0, 0, 0.01) 2%, #1F2226 116%
    );
}

.fade-move, /* apply transition to moving elements */
.fade-enter-active,
.fade-leave-active {
    opacity: 1;
    transition: all 0.75s ease-in-out;
}


.fade-enter-from,
.fade-leave-to {
    width: 0;
    opacity: 0;
    padding-right: 0;
    padding-left: 0;
    transform: translateX(30px);
}

</style>
