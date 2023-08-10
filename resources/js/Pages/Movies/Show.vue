<script lang="ts" setup>

import {Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import MovieDetailRow from "@/Components/Movies/MovieDetailRow.vue";
import ScreeningList from "@/Components/Screenings/ScreeningList.vue";
</script>

<template>
  <Head>
    <title>Головна сторінка</title>
  </Head>

  <MainLayout>
    <section class="pt-1">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <div
              class="flex flex-col sm:flex-row lg:space-x-10 sm:space-x-8 space-y-6 sm:space-y-0">
            <div
                class="lg:w-72 md:w-60 sm:w-48 w-full max-h-[500px] overflow-hidden rounded-md self-center sm:self-auto shrink-0">
              <img alt="movie poster" class="w-full h-full bg-cover content-center" src="/images/defaults/joker.jpg">
            </div>

            <div>
              <h1 class="lg:text-4xl md:text-3xl sm:text-2xl text-xl font-medium text-white">
                Підлітки-мутанти Черепашки-ніндзя: Погром мутантів
              </h1>

              <ul class="font-sans lg:mt-3 mt-2 font-medium md:space-y-2 space-y-1">
                <MovieDetailRow title="Вік:" value="0+"/>
                <MovieDetailRow title="Оригінальна назва:" value="Teenage Mutant Ninja Turtles: Mutant Mayhem"/>
                <MovieDetailRow title="Режисер:" value="Джефф Роу, Кайлер Спірс"/>
                <MovieDetailRow title="Період прокату:" value="02.08.2023 - 30.08.2023"/>
                <MovieDetailRow title="Жанр:" value="Анімація, Пригоди, Комедія"/>
                <MovieDetailRow title="Тривалість:" value="1 год 54 хв"/>
                <MovieDetailRow title="Виробництво:" value="США"/>
                <MovieDetailRow title="Студія:" value="Paramount Pictures"/>
                <MovieDetailRow title="У головних ролях:"
                                value="Сет Роген, Ділан О’Брайен, Коді Крістіан, Стівен Блум, Сієна Агудонг"/>
              </ul>
            </div>
          </div>
          <div class="sm:mt-4 font-sans text-white">
            <h6 class="font-medium text-sm sm:hidden">Опис</h6>

            <p class="text-sm md:text-base text-neutral-400 sm:text-white">
              Довгий час вони ховалися від навколишнього світу в міській каналізації. Проте нарешті герої вирішують
              піднятися нагору, щоб жити життям звичайних підлітків серед жителів Нью-Йорку. Та зовсім скоро їм
              доведеться зіткнутися з могутньою армією мутантів, що загрожуватиме місту. Тож разом з новою подругою
              Ейпріл О’Ніл безстрашні черепашки зроблять усе, аби зупинити ворога
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="my-8">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <ScreeningList/>
        </div>
      </div>
    </section>

  </MainLayout>
</template>

<style scoped></style>
