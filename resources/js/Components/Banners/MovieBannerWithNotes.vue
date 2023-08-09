<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import ZoomableBanner from "@/Components/Banners/ZoomableBanner.vue";
import NoteItem from "@/Components/Banners/NoteItem.vue";
import type {IBanner} from "@/types/banners/IBanner";
import {computed} from "vue";

const {banner} = defineProps<{ banner: IBanner }>()

const formattedGenres = computed(() => {
  return banner.genres.map(genre => genre.name).join(', ')
})
</script>

<template>
  <div class="flex space-x-4">
    <Link :href="route('movies.show', {movie: banner.slug})" class="xl:min-w-[70%] lg:min-w-3/5 w-full">
      <ZoomableBanner :image="banner.image">
        <div class="self-end text-white lg:p-10 md:p-8 p-6">

          <h2 class="lg:text-5xl md:text-4xl text-3xl font-semibold">{{ banner.title }}</h2>

          <p class="my-3 line-clamp-2 w-4/5 font-light font-sans">{{ banner.description }} </p>

          <div class="flex space-x-4 text-sm">
            <div>з {{ banner.start_showing }}</div>
            <div>{{ banner.duration }}</div>
          </div>
        </div>
      </ZoomableBanner>
    </Link>

    <div class="border border-gray-800 xl:w-full lg:w-1/2 min-h-full rounded-3xl hidden lg:block">
      <div
          class="bg-tertiary text-white w-full min-h-full rounded-3xl p-6 flex justify-between flex-col">
        <ul class="space-y-[5px]">
          <NoteItem title="Закінчення показу:">{{ banner.end_showing }}</NoteItem>
          <NoteItem title="Жанр:">{{ formattedGenres }}</NoteItem>
          <NoteItem title="В головних ролях:">{{ banner.main_cast }}</NoteItem>
          <NoteItem title="Країна:">{{ banner.production_country }}</NoteItem>
          <NoteItem title="Цікавий факт:">{{ banner.fact }}</NoteItem>
        </ul>
        <!--TODO update endpoint -->
        <Link :href="route('home')"
              class="bg-secondary text-white font-semibold py-4 px-6 rounded-md text-center">
          Продивитися сеанси
        </Link>

      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
