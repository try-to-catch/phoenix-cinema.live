<script lang="ts" setup>
import {Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import LocationDot from "@/Components/Icons/LocationDot.vue";
import CalendarDays from "@/Components/Icons/CalendarDays.vue";
import InfoItem from "@/Components/Screenings/InfoItem.vue";
import ClockIcon from "@/Components/Icons/ClockIcon.vue";
import ScreenArch from "@/Components/Screenings/ScreenArch.vue";
import MoviePoster from "@/Components/Movies/MoviePoster.vue";
import SeatCard from "@/Components/Screenings/SeatCard.vue";
import SeatPlan from "@/Components/Screenings/SeatPlan.vue";
import type {ISeat} from "@/types/seats/ISeat";
import {ref} from "vue";

defineProps<{ seating_plan: Readonly<ISeat>[][] }>()

const selectedSeats = ref<Readonly<ISeat>[]>([])
</script>

<template>
  <Head>
    <title>Вибор місць</title>
  </Head>

  <MainLayout>
    <section class="pt-1">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <div class="flex w-full">
            <MoviePoster age-restriction="16+" class="h-[220px] w-40" thumbnail="/images/defaults/joker.jpg"
                         title="Joker"/>

            <div class="ml-4 w-full space-y-4">
              <h3 class="font-medium text-xl text-white">Ґран туризмо</h3>
              <div class="w-fit ">
                <div class="bg-secondary  font-medium px-4 py-1 flex rounded-md text-white text-sm">3D</div>
              </div>

              <div class="flex text-center space-x-2">
                <InfoItem bottom-text="м. Львів, вул. Коперника, 23" top-text="Зал #2">
                  <LocationDot class="w-6 h-6 fill-white"/>
                </InfoItem>

                <InfoItem bottom-text="Неділя" top-text="13.08.2023">
                  <CalendarDays class="w-6 h-6 fill-white"/>
                </InfoItem>

                <InfoItem bottom-text="20:10 - 22:16" top-text="Час">
                  <ClockIcon class="w-6 h-6 fill-white"/>
                </InfoItem>
              </div>
            </div>
          </div>

          <div class="w-full mt-4">
            <div class="flex flex-col justify-center">
              <div class="flex space-x-4 justify-center">
                <div class="flex space-x-2 items-center font-sans">
                  <SeatCard class="bg-blue-400"/>
                  <div class="text-sm leading-3 text-white">
                    <div class="uppercase">Standard</div>
                    <span class="">- 140 <small>грн</small></span>
                  </div>
                </div>

                <div class="flex space-x-2 items-center font-sans">
                  <SeatCard class="bg-secondary"/>
                  <div class="text-sm leading-3 text-white">
                    <div class="uppercase">Premium</div>
                    <span class="">- 220 <small>грн</small></span>
                  </div>
                </div>
              </div>

              <div class="w-full text-center mt-4">
                <ScreenArch class="fill-neutral-500"/>
                <div class="font-sans text-white font-medium">ЭКРАН</div>
              </div>
            </div>

            <div class="w-full flex justify-center mt-12">
              <SeatPlan :seating-plan="seating_plan" v-model:selected-seats="selectedSeats"/>
            </div>

          </div>
        </div>
      </div>

    </section>
  </MainLayout>
</template>

<style scoped>

</style>
