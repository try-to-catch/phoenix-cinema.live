<script lang="ts" setup>
import {Head} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import MovieBannerWithNotes from "@/Components/Banners/MovieBannerWithNotes.vue";
import H3Title from "@/Components/Titles/H3Title.vue";
import MovieList from "@/Components/Movies/MovieList.vue";
import AdvantagesSection from "@/Components/Advantages/AdvantagesSection.vue";
import type {IMovieCard} from "@/types/movies/IMovieCard";
import type {IBanner} from "@/types/banners/IBanner";

const {banner, movies, future_movies} = defineProps<{
  banner: IBanner;
  movies: readonly Readonly<IMovieCard>[];
  future_movies: readonly Readonly<IMovieCard>[]
}>()

</script>

<template>
  <Head>
    <title>Головна сторінка</title>
  </Head>

  <MainLayout>
    <section class="pt-1">
      <div class="container">
        <MovieBannerWithNotes :banner="banner" class="h-[400px]"/>
      </div>
    </section>

    <AdvantagesSection class="my-12"/>

    <section class="mb-12">
      <div class="container">
        <H3Title>Зараз у кіно</H3Title>

        <MovieList class="mt-5" :movies="movies"/>
      </div>
    </section>

    <section class="mb-12">
      <div class="container">
        <H3Title>Скоро у кіно</H3Title>

        <MovieList class="mt-5" :movies="future_movies"/>
      </div>
    </section>
  </MainLayout>
</template>

<style scoped></style>
