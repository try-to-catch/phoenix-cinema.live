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
import {SeatType} from "@/types/seats/ISeat";
import {ref} from "vue";
import SelectedSeatCard from "@/Components/Screenings/SelectedSeatCard.vue";
import type {IScreeningInfo} from "@/types/screenings/IScreeningInfo";

const {seating_plan, screening} = defineProps<{
    seating_plan: Readonly<ISeat>[][],
    screening: Readonly<IScreeningInfo>
}>()

const selectedSeats = ref<Readonly<ISeat>[]>([])
const removeSeat = (seat: ISeat) => {
    selectedSeats.value = selectedSeats.value.filter(selectedSeat => selectedSeat.id !== seat.id)
}
const getSeatPrice = (seat: ISeat) => seat.type === SeatType.Standard ? screening.standard_seat_price : screening.premium_seat_price
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
                        <MoviePoster :age-restriction="screening.movie.age_restriction" class="h-[220px] w-40 shrink-0"
                                     :thumbnail="screening.movie.thumbnail"
                                     :title="screening.movie.title"/>

                        <div class="ml-4 w-full space-y-4">
                            <h3 class="font-medium text-xl text-white"></h3>
                            <div class="w-fit ">
                                <div class="bg-secondary  font-medium px-4 py-1 flex rounded-md text-white text-sm">3D
                                </div>
                            </div>

                            <div class="flex text-center space-x-2">
                                <InfoItem :bottom-text="screening.hall.address"
                                          :top-text="`Зал #${screening.hall.number}`">
                                    <LocationDot class="w-6 h-6 fill-white"/>
                                </InfoItem>

                                <InfoItem :bottom-text="screening.start_date_day_of_weak"
                                          :top-text="screening.start_date">
                                    <CalendarDays class="w-6 h-6 fill-white"/>
                                </InfoItem>

                                <InfoItem :bottom-text="`${screening.start_time} - ${screening.end_time}`"
                                          top-text="Час">
                                    <ClockIcon class="w-6 h-6 fill-white"/>
                                </InfoItem>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-4">
            <div class="container">
                <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
                    <div class="flex flex-col justify-center">
                        <div class="flex space-x-4 justify-center">
                            <div class="flex space-x-2 items-center font-sans">
                                <SeatCard class="bg-blue-400"/>
                                <div class="text-sm leading-3 text-white">
                                    <div class="uppercase">Standard</div>
                                    <span class="">- {{ screening.standard_seat_price }} <small>грн</small></span>
                                </div>
                            </div>

                            <div class="flex space-x-2 items-center font-sans">
                                <SeatCard class="bg-secondary"/>
                                <div class="text-sm leading-3 text-white">
                                    <div class="uppercase">Premium</div>
                                    <span class="">- {{ screening.premium_seat_price }} <small>грн</small></span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full text-center mt-4">
                            <ScreenArch class="fill-neutral-500"/>
                            <div class="font-sans text-white font-medium">ЭКРАН</div>
                        </div>
                    </div>

                    <div class="w-full flex justify-center mt-12">
                        <SeatPlan v-model:selected-seats="selectedSeats" :seating-plan="seating_plan"/>
                    </div>
                </div>
            </div>
        </section>


        <section v-if="selectedSeats.length" class="mt-12">
            <div class="container">
                <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
                    <div class="w-full grid grid-cols-2 gap-5">
                        <SelectedSeatCard v-for="seat in selectedSeats" :key="seat.id"
                                          @remove="removeSeat(seat)"
                                          :price="getSeatPrice(seat)"
                                          :row="seat.row_number" :seat="seat.seat_number" :type="seat.type"/>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
