<script lang="ts" setup>
import MovieCard from '@/Components/Movies/MovieCard.vue'
import type { IMovieCard } from '@/types/movies/IMovieCard'

const { movies, routeName } = defineProps<{
  movies: readonly IMovieCard[]
  routeName?: string
  cardSize?: 'sm' | 'normal'
}>()
</script>

<template>
  <ul
    class="overflow-hidden grid gap-5 2xl:grid-cols-6 xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1"
  >
    <MovieCard v-for="movie in movies" :key="movie.id" :movie="movie" :route-name="routeName" :size="cardSize" />
  </ul>
</template>
