<script lang="ts" setup>
import {Head} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import MovieBannerWithNotes from "@/Components/Banners/MovieBannerWithNotes.vue";
import H3Title from "@/Components/Titles/H3Title.vue";
import MovieList from "@/Components/Movies/MovieList.vue";
import AdvantagesSection from "@/Components/Advantages/AdvantagesSection.vue";
</script>

<template>
    <Head>
        <title>Головна сторінка</title>
    </Head>

    <MainLayout>
        <section class="py-1">
            <div class="container">
                <MovieBannerWithNotes class="h-[400px]"/>
            </div>
        </section>

        <AdvantagesSection class="mt-12"/>

        <section class="mt-12">
            <div class="container">
                <H3Title>Зараз у кіно</H3Title>

                <MovieList class="mt-5"/>
            </div>
        </section>
    </MainLayout>
</template>

<style scoped></style>
