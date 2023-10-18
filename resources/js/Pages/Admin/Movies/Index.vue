<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import type { IPaginatedMovieCards } from '@/types/movies/IPaginatedMovieCards'
import PaginatedTable from '@/Components/Tables/PaginatedTable.vue'
import { computed, onMounted, ref, toRefs } from 'vue'

const props = defineProps<{
  movies: Readonly<IPaginatedMovieCards>
}>()

const { movies } = toRefs(props)

const formattedMovies = computed(() => {
  return movies.value.data.map(movie => {
    return {
      ...movie,
      genres: movie.genres.map(genre => genre.name).join(', '),
    }
  })
})

const searchInput = ref('')

const filterProducts = () => {
  const oldSearchInput = searchInput.value

  setTimeout(() => {
    if (searchInput.value === oldSearchInput) {
      console.log('searchInput.value', oldSearchInput)
      router.reload({
        data: {
          s: oldSearchInput,
        },
      })
    }
  }, 1250)
}
onMounted(() => {
  const url = new URL(window.location.href)

  searchInput.value = url.searchParams.get('s') ?? ''
})
</script>

<template>
  <Head title="Фільми" />
  <AdminLayout :is-wide="true">
    <div class="py-12">
      <div class="container">
        <div class="space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <h2 class="text-lg font-medium text-white pb-4">Фільми ({{ movies.meta.total }}){{ searchInput }}</h2>
            <PaginatedTable
              v-model:search-input="searchInput"
              :items="formattedMovies"
              route-item-key="slug"
              route-name="admin.movies.edit"
              :pagination-meta-links="movies.meta.links"
              create-link-route-name="admin.movies.create"
              @update:search-input="filterProducts"
            />
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped></style>
