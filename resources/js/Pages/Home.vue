<script lang="ts" setup>
import {Head, Link} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import MovieBannerWithNotes from "@/Components/Banners/MovieBannerWithNotes.vue";
import H3Title from "@/Components/Titles/H3Title.vue";
import MovieList from "@/Components/Movies/MovieList.vue";
import AdvantagesSection from "@/Components/Advantages/AdvantagesSection.vue";
import type {IMovieCard} from "@/types/movies/IMovieCard";
import type {IBanner} from "@/types/banners/IBanner";
import AnglesRight from "@/Components/Icons/AnglesRight.vue";

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
    <section class="pt-5 sm:pt-1">
      <div class="container">
        <MovieBannerWithNotes :banner="banner" class="h-[400px]"/>
      </div>
    </section>

    <AdvantagesSection class="py-12"/>

    <section v-if="movies.length" class="pb-6 sm:pb-12">
      <div class="container">
        <div class="flex justify-between items-center">
          <H3Title>Зараз у кіно</H3Title>

          <Link class="text-neutral-400 flex items-center space-x-4 sm:text-base text-sm" :href="'/'">
            Показати всі
            <AnglesRight class="ml-2 fill-current"/>
          </Link>
        </div>

        <MovieList :movies="movies" class="mt-5"/>
      </div>
    </section>

    <section v-if="future_movies.length" class="mb-12">
      <div class="container">
        <div class="flex justify-between items-center">
          <H3Title>Скоро у кіно</H3Title>

          <Link class="text-neutral-400 flex items-center space-x-4 sm:text-base text-sm" :href="'/'">
            Показати всі
            <AnglesRight class="ml-2 fill-current"/>
          </Link>
        </div>
        <MovieList :movies="future_movies" class="mt-5"/>
      </div>
    </section>
  </MainLayout>
</template>

<style scoped></style>
