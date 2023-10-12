<script lang="ts" setup>
import MovieList from '@/Components/Movies/MovieList.vue'
import Pagination from '@/Components/Shared/Pagination.vue'
import type { IMovieCard } from '@/types/movies/IMovieCard'
import type { IPaginationMetaLink } from '@/types/shared/pagination/IPaginationMetaLink'

const { movies, links, cardSize } = defineProps<{
  movies: readonly IMovieCard[]
  links: IPaginationMetaLink[]
  routeName?: string
  cardSize?: 'sm' | 'normal'
}>()
</script>

<template>
  <div class="flex flex-col items-center">
    <MovieList :movies="movies" :route-name="routeName" :card-size="cardSize" />

    <Pagination :links="links" class="mt-5" />
  </div>
</template>
