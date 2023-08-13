<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import {ref} from "vue";
import type {IMovieCard} from "@/types/movies/IMovieCard";
import {formatGenres} from "@/services/formatGenres";
import MoviePoster from "@/Components/Movies/MoviePoster.vue";

const {movie} = defineProps<{ movie: IMovieCard }>()

const isHovered = ref(false)
</script>

<template>
  <li :title="movie.title"
      class="min-w-[218px] w-full flex justify-center min-h-[322px] cursor-pointer relative"
      @mouseleave="isHovered = false"
      @mouseover="isHovered = true"
  >
    <Link :href="route('movies.show', {movie: movie.slug})" class="block">
      <MoviePoster :title="movie.title" :thumbnail="movie.thumbnail" :age-restriction="movie.age_restriction"/>

      <transition name="liftUp">
        <div v-if="isHovered"
             class="absolute bottom-0 w-full h-full rounded-md bg-gradient-to-t from-black to-transparent p-6 flex flex-col justify-end right-1/2 translate-x-1/2 sm:right-0 sm:translate-x-0">
          <h6 class="text-sm  text-white font-medium">
            {{ movie.title }}
          </h6>

          <ul class="my-6 space-y-2">
            <li class="leading-5">
              <div class="text-xs text-gray-400 mb-1 font-medium">Жанр</div>
              <div class="text-xs text-white">{{ formatGenres(movie.genres) }}</div>
            </li>
            <li class="leading-5">
              <div class="text-xs text-gray-400 mb-1 font-medium">Режисер</div>
              <div class="text-xs text-white">{{ movie.director }}</div>
            </li>
          </ul>

          <div class="text-xs  text-secondary font-medium">
            {{ movie.start_showing }} - {{ movie.end_showing }}
          </div>
        </div>
      </transition>

    </Link>

  </li>
</template>


<style scoped>
.liftUp-enter-active,
.liftUp-leave-active {
  transition: opacity 0.5s ease;
}

.liftUp-enter-from,
.liftUp-leave-to {
  opacity: 0;
}
</style>
