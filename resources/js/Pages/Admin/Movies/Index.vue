<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { IPaginatedMovieCards } from '@/types/movies/IPaginatedMovieCards'
import PaginatedMovieList from '@/Components/Movies/PaginatedMovieList.vue'

const { movies } = defineProps<{
  movies: readonly Readonly<IPaginatedMovieCards>[]
}>()
</script>

<template>
  <Head>Фільми</Head>
  <AdminLayout>
    <div class="py-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <h2 class="text-lg font-medium text-white">Фільми ({{ movies.meta.total }})</h2>

            <PaginatedMovieList
              :links="movies.meta.links"
              :movies="movies.data"
              class="mt-5"
              card-size="sm"
              route-name="admin.movies.show"
            />
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped></style>
