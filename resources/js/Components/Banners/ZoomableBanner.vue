<script setup lang="ts">

import {ref} from "vue";

import {Link} from "@inertiajs/vue3";

const isMouseOverBanner = ref(false);
</script>

<template>
    <Link href="/public">
        <div class="h-full relative scroll-smooth flex overflow-hidden rounded-3xl"
             @mouseover="isMouseOverBanner = true"
             @mouseleave="isMouseOverBanner = false">
            <div :class="{'scale-105': isMouseOverBanner}"
                 class="absolute bg-[url('/images/defaults/banner.jpg')] bg-center bg-cover w-full h-full bg-no-repeat rounded-3xl flex active duration-500 ease"
            >

                <div class="absolute h-full w-full top-0 ">
                    <div class="h-full w-full absolute rounded-[0.58rem]" :class="$style['gradient-0']"></div>
                </div>
            </div>

            <div class="z-10 flex">
                <slot/>
            </div>
        </div>
    </Link>
</template>


<style module>
.gradient-0 {
    background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.01) 25%, rgba(0, 0, 0, 0.01) 2%, #1F2226 116%
    );
}
</style>
