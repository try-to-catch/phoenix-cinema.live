<script lang="ts" setup>
import {Head} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import {ref} from "vue";
import AnimatedCarousel from "@/Components/AnimatedCarousel.vue";

const activeSlide = ref(0);

const changeActiveSlide = (id: number) => {
    activeSlide.value = id;
}
</script>

<template>
    <Head>
        <title>Головна сторінка</title>
    </Head>

    <MainLayout>
        <div class="py-4">
            <section class="container">
                <animated-carousel/>
            </section>
        </div>
    </MainLayout>
</template>

<style scoped></style>
