<script setup lang="ts">

import ZoomableBanner from "@/Components/Banners/ZoomableBanner.vue";
import NoteItem from "@/Components/Banners/NoteItem.vue";
</script>

<template>
    <div class="flex space-x-4">
        <ZoomableBanner class="xl:min-w-[70%] lg:min-w-3/5 w-full">
            <div class="self-end text-white lg:p-10 md:p-8 p-6">

                <h2 class="lg:text-5xl md:text-4xl text-3xl font-semibold">Інтерстайлер</h2>

                <p class="my-3 line-clamp-2 w-4/5 font-light font-sans">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur et hic
                    id in magni praesentium ratione. Deserunt dolorem enim ipsum iste, maxime minus
                    odit
                    perferendis sint vitae voluptates voluptatibus voluptatum!
                </p>


                <div class="flex space-x-4 text-sm">
                    <div>з 10.02.2023</div>
                    <div>1 г 53 м</div>
                </div>
            </div>
        </ZoomableBanner>

        <div class="border border-gray-800 xl:w-full lg:w-1/2 min-h-full rounded-3xl hidden lg:block">
            <div
                class="bg-tertiary text-white w-full min-h-full rounded-3xl p-6 flex justify-between flex-col">
                <ul class="space-y-[5px]">
                    <NoteItem title="Закінчення показу:">10.05.2023</NoteItem>
                    <NoteItem title="Жанр:">Фантастика, драма, пригоди</NoteItem>
                    <NoteItem title="В головних ролях:">
                        Метью МакКонахі, Енн Гетевей, Джессіка Честейн, Метт Деймон,
                        МакКензі Фой, Майкл Кейн, Кейсі Аффлек
                    </NoteItem>
                    <NoteItem title="Країна:">США, Великобританія</NoteItem>
                    <NoteItem title="Цікавий факт:">
                        Фільм було знято за мотивами роману «Інтерстеллар» Крістофера Нолана та Ліси Джой
                    </NoteItem>
                </ul>

                <button class="bg-secondary text-white font-semibold py-4 px-6 rounded-md">
                    Продивитися сеанси
                </button>

            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
