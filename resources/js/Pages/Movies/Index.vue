<script lang="ts" setup>

import {Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import H3Title from "@/Components/Titles/H3Title.vue";
import MovieList from "@/Components/Movies/MovieList.vue";
import type {IMovieCard} from "@/types/movies/IMovieCard";
import type {IPaginatedMovieCards} from "@/types/movies/IPaginatedMovieCards";
import {computed} from "vue";
import PaginatedMovieList from "@/Components/Movies/PaginatedMovieList.vue";

const {movies, future_movies} = defineProps<{
  movies: readonly Readonly<IMovieCard>[];
  future_movies: IPaginatedMovieCards;
}>()


const moviesLength = computed(() => movies.length)
</script>

<template>
  <Head>
    <title>Афіша</title>
  </Head>

  <MainLayout>
    <section v-if="moviesLength" class="pt-5 sm:pt-5">
      <div class="container">
        <H3Title>Зараз у кіно ({{ moviesLength }})</H3Title>

        <MovieList :movies="movies" class="mt-5"/>
      </div>
    </section>

    <section v-if="future_movies.data.length" class="pt-12 pb-12">
      <div class="container">
        <H3Title>Скоро у кіно ({{ future_movies.meta.total }})</H3Title>

        <PaginatedMovieList :links="future_movies.meta.links" :movies="future_movies.data" class="mt-5"/>
      </div>
    </section>
  </MainLayout>
</template>

