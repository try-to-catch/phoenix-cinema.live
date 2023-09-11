<script lang="ts" setup>
import MovieList from '@/Components/Movies/MovieList.vue'
import Pagination from '@/Components/Shared/Pagination.vue'
import type { IMovieCard } from '@/types/movies/IMovieCard'
import type { IPaginationMetaLink } from '@/types/shared/pagination/IPaginationMetaLink'

const { movies, links } = defineProps<{
  movies: readonly IMovieCard[]
  links: IPaginationMetaLink[]
}>()
</script>

<template>
  <div class="flex flex-col items-center">
    <MovieList :movies="movies" />

    <Pagination :links="links" class="mt-5" />
  </div>
</template>
