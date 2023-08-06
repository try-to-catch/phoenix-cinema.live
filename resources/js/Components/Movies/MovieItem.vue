<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import {computed, ref} from "vue";
import type {IMovieCard} from "@/types/movies/IMovieCard";

const {movie} = defineProps<{ movie: IMovieCard }>()

const isHovered = ref(false)

const formattedGenres = computed(() => {
  return movie.genres.map((genre) => genre.name).join(', ')
})
</script>

<template>
  <li :title="movie.title"
      class="min-w-[218px] w-full flex justify-center min-h-[322px] cursor-pointer relative"
      @mouseover="isHovered =true"
      @mouseleave="isHovered = false"
  >
    <!--TODO update endpoint -->
    <Link class="block" :href="route('home')">
      <img :alt="`${movie.title} poster`" :src="movie.thumbnail" class="rounded-md">

      <div class="w-8 h-8 text-xs absolute rounded-md top-2 left-2 bg-white flex justify-center items-center">
        {{ movie.age_restriction }}
      </div>

      <transition name="liftUp">
        <div v-if="isHovered"
             class="absolute bottom-0 w-full h-full rounded-md bg-gradient-to-t from-black to-transparent p-6 flex flex-col justify-end right-1/2 translate-x-1/2 sm:right-0 sm:translate-x-0">
          <h6 class="text-sm  text-white font-medium">
            {{ movie.title }}
          </h6>

          <ul class="my-6 space-y-2">
            <li class="leading-5">
              <div class="text-xs text-gray-400 mb-1 font-medium">Жанр</div>
              <div class="text-xs text-white">{{ formattedGenres }}</div>
            </li>
            <li class="leading-5">
              <div class="text-xs text-gray-400 mb-1 font-medium">Режисер</div>
              <div class="text-xs text-white">{{ movie.director }}</div>
            </li>
          </ul>

          <div class="text-xs  text-secondary font-medium">{{ movie.start_showing }} - {{ movie.end_showing }}</div>
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
