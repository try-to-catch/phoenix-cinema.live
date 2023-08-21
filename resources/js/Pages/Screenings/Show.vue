<script lang="ts" setup>
import {Head, router, usePage} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import LocationDot from "@/Components/Icons/LocationDot.vue";
import CalendarDays from "@/Components/Icons/CalendarDays.vue";
import InfoItem from "@/Components/Screenings/InfoItem.vue";
import ClockIcon from "@/Components/Icons/ClockIcon.vue";
import ScreenArch from "@/Components/Screenings/ScreenArch.vue";
import MoviePoster from "@/Components/Movies/MoviePoster.vue";
import SeatPlan from "@/Components/Screenings/SeatPlan.vue";
import type {ISeat} from "@/types/seats/ISeat";
import {SeatType} from "@/types/seats/ISeat";
import {computed, ref, watch} from "vue";
import SelectedSeatCard from "@/Components/Screenings/SelectedSeatCard.vue";
import type {IScreeningInfo} from "@/types/screenings/IScreeningInfo";
import SeatTypePrice from "@/Components/Screenings/SeatTypePrice.vue";
import Modal from "@/Components/Breeze/Modal.vue";
import PrimaryButton from "@/Components/Breeze/PrimaryButton.vue";
import SecondaryButton from "@/Components/Breeze/SecondaryButton.vue";
import TextInput from "@/Components/Breeze/TextInput.vue";
import NumberInput from "@/Components/Breeze/NumberInput.vue";

const {props: globalProps} = usePage()
const {seating_plan, screening} = defineProps<{
  seating_plan: Readonly<ISeat>[][],
  screening: Readonly<IScreeningInfo>
}>()

const selectedSeats = ref<Readonly<ISeat>[]>([])
const removeSeat = (seat: ISeat) => {
  selectedSeats.value = selectedSeats.value.filter(selectedSeat => selectedSeat.id !== seat.id)
}

const extendedSelectedSeats = computed(() => {
  return selectedSeats.value.map(seat => {
    return {
      ...seat,
      price: seat.type === SeatType.Standard ? screening.standard_seat_price : screening.premium_seat_price
    }
  })
})

const orderTotalPrice = computed(() => {
  return extendedSelectedSeats.value.reduce((total, seat) => total + seat.price, 0)
})

const orderTotalCount = computed(() => {
  return selectedSeats.value.length
})

const isPaymentAvailable = ref(false)
const isAuthSuggestionsModalOpen = ref(false)
const suggestAuth = () => {
  if (globalProps.auth.user) {
    isPaymentAvailable.value = true
    return
  }

  isAuthSuggestionsModalOpen.value = true
}

const redirectToLogin = () => {
  router.visit(route('login'))
}

const rejectAuth = () => {
  isAuthSuggestionsModalOpen.value = false
  isPaymentAvailable.value = true
}

const tmp = ref(1)

watch(selectedSeats, () => {
  if (!selectedSeats.value.length) {
    isPaymentAvailable.value = false
  }
})
</script>

<template>
  <Head>
    <title>Вибор місць</title>
  </Head>

  <MainLayout>
    <!--screening info -->
    <section class="pt-5 sm:pt-1">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <h3 class="sm:hidden font-medium text-lg text-white mb-1.5">{{ screening.movie.title }}</h3>

          <div class="flex w-full">
            <MoviePoster :age-restriction="screening.movie.age_restriction"
                         :thumbnail="screening.movie.thumbnail"
                         :title="screening.movie.title"
                         class="sm:h-[220px] h-40  shrink-0"/>

            <div class="ml-4 w-full space-y-2 sm:space-y-3 md:space-y-4">
              <h3 class="font-medium md:text-xl text-lg text-white sm:block hidden">
                {{ screening.movie.title }}</h3>
              <div class="w-fit">
                <div
                    class="bg-secondary font-medium px-2.5 sm:px-4 py-0.5 sm:py-1 flex rounded-md text-white text-xs sm:text-sm">
                  3D
                </div>
              </div>

              <div class="flex lg:flex-row flex-col lg:space-x-2">
                <InfoItem :bottom-text="screening.hall.address"
                          :reverse-on-mobile="true"
                          :top-text="`Зал #${screening.hall.number}`">
                  <LocationDot class="lg:w-6 lg:h-6 md:w-5 md:h-5 w-4 h-4 fill-white"/>
                </InfoItem>

                <InfoItem :bottom-text="screening.start_date_day_of_weak"
                          :top-text="screening.start_date">
                  <CalendarDays class="lg:w-6 lg:h-6 md:w-5 md:h-5 w-4 h-4 fill-white"/>
                </InfoItem>

                <InfoItem :bottom-text="`${screening.start_time} - ${screening.end_time}`"
                          top-text="Час">
                  <ClockIcon class="lg:w-6 lg:h-6 md:w-5 md:h-5 w-4 h-4 fill-white"/>
                </InfoItem>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!--seat plan-->
    <section v-if="!isPaymentAvailable" class="sm:pt-4 pt-6">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <div class="flex flex-col justify-center">
            <div class="flex space-x-4 justify-center">
              <SeatTypePrice :price="screening.standard_seat_price" :label="SeatType.Standard"
                             seat-color-class="bg-blue-400"/>

              <SeatTypePrice :price="screening.premium_seat_price" :label="SeatType.Premium"
                             seat-color-class="bg-secondary"/>
            </div>

            <div class="w-full text-center mt-4">
              <ScreenArch class="fill-neutral-500"/>
              <div class="font-sans text-white font-medium text-sm sm:text-md">ЭКРАН</div>
            </div>
          </div>

          <div class="w-full flex justify-center sm:mt-12 mt-9">
            <SeatPlan v-model:selected-seats="selectedSeats" :seating-plan="seating_plan"/>
          </div>
        </div>
      </div>
    </section>

    <!--selected seats-->
    <section v-if="selectedSeats.length" class="pt-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <div class="flex justify-between items-center">
            <div class="font-medium text-white text-base sm:text-lg">Кількість місць</div>
            <div class="font-medium text-white text-base sm:text-lg">
              {{ orderTotalCount }}
              <small class="text-xs">шт.</small>
            </div>
          </div>

          <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-5 mt-4">
            <SelectedSeatCard v-for="seat in extendedSelectedSeats" :key="seat.id"
                              :price="seat.price"
                              :row="seat.row_number"
                              :seat="seat.seat_number" :type="seat.type" @remove="removeSeat(seat)"/>
          </div>
        </div>
      </div>
    </section>

    <section v-if="isPaymentAvailable" class="pt-12 pb-4">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <div class="font-medium text-white text-base sm:text-lg">Оплата</div>
          <!--request card number, expire date and cvv code-->

          <div class=" border-secondary mt-4 rounded-lg">
            <TextInput id="card_number" label-inner="Номер картки" v-model="tmp" type="text"/>

            <div class="grid grid-cols-3 gap-4 mt-4">
              <NumberInput id="expire_month" label-inner="Місяць" :min="1" :max="12" v-model="tmp"/>
              <NumberInput id="expire_year" label-inner="Рік" :min="2023" :max="2040" v-model="tmp"/>
              <NumberInput id="cvv_code" label-inner="CVV код" :min="100" :max="999" v-model="tmp"/>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!--Total price and button-->
    <section v-if="selectedSeats.length" class="pt-8 pb-6 sm:pb-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <div class="flex justify-between items-center w-full">
            <div class="font-medium text-white text-base sm:text-lg">Загальна сума</div>
            <div class="font-medium text-white text-base sm:text-lg">
              {{ orderTotalPrice }}
              <small class="text-xs">грн</small>
            </div>
          </div>

          <div class="flex justify-center mt-4">
            <button v-if="!isPaymentAvailable" @click="suggestAuth"
                    class="text-sm sm:text-base   bg-secondary font-medium w-full py-2 rounded-md text-white">
              Підтвердити
            </button>

            <button v-if="isPaymentAvailable" @click="console.log('payment')"
                    class="text-sm sm:text-base   bg-secondary font-medium w-full py-2 rounded-md text-white">
              Сплатити
            </button>
          </div>
        </div>
      </div>
    </section>

    <!--auth suggestions modal-->
    <Modal :show="isAuthSuggestionsModalOpen" max-width="2xl">
      <div class="p-6">
        <div class="flex flex-col items-center">
          <div class="w-32">
            <img src="/images/emoji/thinking-face.png" alt="thinking face emoji" class="w-full h-full">
          </div>

          <div class="font-medium text-white text-base sm:text-lg my-3">Бажаєте авторизуватися?</div>
          <div class="text-sm sm:text-sm text-center text-neutral-400">
            Авторизація дасть змогу зберігати квитки в особистому кабінеті, і отримувати доступ до них з
            будь-якого пристрою
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3 mt-5">
          <SecondaryButton @click="rejectAuth">Іншого разу</SecondaryButton>

          <PrimaryButton @click="redirectToLogin">Так, звісно</PrimaryButton>
        </div>


      </div>
    </Modal>
  </MainLayout>
</template>
