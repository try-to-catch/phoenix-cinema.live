<script lang="ts" setup>
import { Head } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import MovieDetailRow from '@/Components/Movies/MovieDetailRow.vue'
import ScreeningList from '@/Components/Screenings/ScreeningList.vue'
import type { IMovie } from '@/types/movies/IMovie'
import { formatGenres } from '@/services/formatGenres'
import type { IOrganizedScreening } from '@/types/screenings/IOrganizedScreening'

const { movie, screenings } = defineProps<{
  movie: Readonly<IMovie>
  screenings: Readonly<IOrganizedScreening>[]
}>()
</script>

<template>
  <Head>
    <title>Головна сторінка</title>
  </Head>

  <MainLayout>
    <section class="pt-5 sm:pt-1">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <div class="flex flex-col sm:flex-row lg:space-x-10 sm:space-x-8 space-y-6 sm:space-y-0">
            <div
              class="lg:w-72 md:w-60 sm:w-48 w-full max-h-[500px] overflow-hidden rounded-md self-center sm:self-auto shrink-0"
            >
              <img
                :alt="`Постер ${movie.title}`"
                class="w-full h-full bg-cover content-center"
                :src="movie.thumbnail"
              />
            </div>

            <div>
              <h1 class="lg:text-4xl md:text-3xl sm:text-2xl text-xl font-medium text-white">
                {{ movie.title }}
              </h1>

              <ul class="font-sans lg:mt-3 mt-2 font-medium md:space-y-2 space-y-1">
                <MovieDetailRow :value="movie.age_restriction" title="Вік:" />
                <MovieDetailRow :value="movie.original_title" title="Оригінальна назва:" />
                <MovieDetailRow :value="movie.director" title="Режисер:" />
                <MovieDetailRow :value="`${movie.start_showing} - ${movie.end_showing}`" title="Період прокату:" />
                <MovieDetailRow :value="formatGenres(movie.genres)" title="Жанр:" />
                <MovieDetailRow :value="movie.duration" title="Тривалість:" />
                <MovieDetailRow :value="movie.production_country" title="Виробництво:" />
                <MovieDetailRow :value="movie.studio" title="Студія:" />
                <MovieDetailRow :value="movie.main_cast" title="У головних ролях:" />
              </ul>
            </div>
          </div>

          <div class="sm:mt-4 font-sans text-white">
            <h6 class="font-medium text-sm sm:hidden">Опис</h6>

            <p class="text-sm md:text-base text-neutral-400 sm:text-white">
              {{ movie.description }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-8 pb-6 sm:pb-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <ScreeningList :screenings="screenings" />
        </div>
      </div>
    </section>
  </MainLayout>
</template>
