<script lang="ts" setup>
import { Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import type { IMovieCard } from '@/types/movies/IMovieCard'
import { formatGenres } from '@/services/formatGenres'
import MoviePoster from '@/Components/Movies/MoviePoster.vue'

const { movie, routeName, size } = withDefaults(
  defineProps<{
    movie: IMovieCard
    routeName?: string
    size?: 'sm' | 'normal'
  }>(),
  { routeName: 'movies.show', size: 'normal' }
)

const isHovered = ref(false)

const cardStyles = computed(() => {
  if (size === 'sm') {
    return ''
  }

  return 'min-w-[218px] min-h-[322px]'
})
</script>

<template>
  <li
    :title="movie.title"
    :class="cardStyles"
    class="w-full flex justify-center cursor-pointer relative"
    @mouseleave="isHovered = false"
    @mouseover="isHovered = true"
  >
    <Link :href="route(routeName, { movie: movie.slug })" class="block">
      <MoviePoster :age-restriction="movie.age_restriction" :thumbnail="movie.thumbnail" :title="movie.title" />

      <transition name="liftUp">
        <div
          v-if="isHovered"
          class="absolute bottom-0 w-full h-full rounded-md bg-gradient-to-t from-black to-transparent p-6 flex flex-col justify-end right-1/2 translate-x-1/2 sm:right-0 sm:translate-x-0"
        >
          <h6 class="text-sm text-white font-medium">
            {{ movie.title }}
          </h6>

          <ul class="my-6 space-y-2">
            <li class="leading-5">
              <div class="text-xs text-neutral-400 mb-1 font-medium">Жанр</div>
              <div class="text-xs text-white">
                {{ formatGenres(movie.genres) }}
              </div>
            </li>
            <li class="leading-5">
              <div class="text-xs text-neutral-400 mb-1 font-medium">Режисер</div>
              <div class="text-xs text-white">
                {{ movie.director }}
              </div>
            </li>
          </ul>

          <div class="text-xs text-secondary font-medium">{{ movie.start_showing }} - {{ movie.end_showing }}</div>
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
