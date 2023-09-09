<script lang="ts" setup>
import {Head, useForm, usePage} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import LocationDot from "@/Components/Icons/LocationDot.vue";
import CalendarDays from "@/Components/Icons/CalendarDays.vue";
import InfoItem from "@/Components/Screenings/InfoItem.vue";
import ClockIcon from "@/Components/Icons/ClockIcon.vue";
import ScreenArch from "@/Components/Screenings/ScreenArch.vue";
import MoviePoster from "@/Components/Movies/MoviePoster.vue";
import SeatPlan from "@/Components/Screenings/SeatPlan.vue";
import SelectedSeatCard from "@/Components/Screenings/SelectedSeatCard.vue";
import SeatTypePrice from "@/Components/Screenings/SeatTypePrice.vue";
import PrimaryButton from "@/Components/Breeze/PrimaryButton.vue";
import SummarizingRow from "@/Components/Payment/SummarizingRow.vue";
import AuthSuggestionModal from "@/Components/Modals/AuthSuggestionModal.vue";
import PaymentSection from "@/Components/Payment/PaymentSection.vue";
import type {ISeat} from "@/types/seats/ISeat";
import {SeatType} from "@/types/seats/ISeat";
import type {IScreeningInfo} from "@/types/screenings/IScreeningInfo";
import type {OrderFormType} from "@/types/orders/OrderFormType";
import {computed, ref, watchEffect} from "vue";

const {seating_plan, screening} = defineProps<{
  seating_plan: Readonly<ISeat>[][],
  screening: Readonly<IScreeningInfo>
}>()

const orderForm = useForm<OrderFormType>({
  seat_ids: [],
  card_data: {
    card_number: '',
    expire_month: null,
    expire_year: null,
    cvv_code: '',
  }
})

const isSeatSelected = computed(() => orderForm.seat_ids.length > 0)

const onSelectSeat = (newSeat: ISeat) => {
  orderForm.seat_ids.push(newSeat.id)
}

const onUnselectSeat = (seat: ISeat) => {
  orderForm.seat_ids = orderForm.seat_ids.filter(seatId => seatId !== seat.id)
}

const removeSeat = (seat: ISeat) => {
  orderForm.seat_ids = orderForm.seat_ids.filter(seatId => seatId !== seat.id)
}

const extendedSelectedSeats = computed(() => {
  return orderForm.seat_ids.map(seatId => {
    const seat = seating_plan.flat().find(seat => seat.id === seatId) as ISeat

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
  return orderForm.seat_ids.length
})

const isPaymentAvailable = ref(false)
const authSuggestionModalRef = ref<InstanceType<typeof AuthSuggestionModal> | null>(null)
const suggestAuth = () => {
  const {props: globalProps} = usePage()

  if (globalProps.auth.user) {
    isPaymentAvailable.value = true
    return
  }

  authSuggestionModalRef.value?.open().then(() => {
    isPaymentAvailable.value = true
  })
}

watchEffect(() => {
  if (!isSeatSelected.value) {
    isPaymentAvailable.value = false
  }
})

const sendStoreOrderRequest = () => {
  orderForm.post(route('orders.store'), {})
}
</script>

<template>
  <Head>
    <title>Вибор місць</title>
  </Head>

  <MainLayout>{{ orderForm.errors }}
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
              <SeatTypePrice :label="SeatType.Standard" :price="screening.standard_seat_price"
                             seat-color-class="bg-blue-400"/>

              <SeatTypePrice :label="SeatType.Premium" :price="screening.premium_seat_price"
                             seat-color-class="bg-secondary"/>
            </div>

            <div class="w-full text-center mt-4">
              <ScreenArch class="fill-neutral-500"/>
              <div class="font-sans text-white font-medium text-sm sm:text-md">ЭКРАН</div>
            </div>
          </div>

          <div class="w-full flex justify-center sm:mt-12 mt-9">
            <SeatPlan :seating-plan="seating_plan" :selected-seats="extendedSelectedSeats"
                      @select-seat="onSelectSeat" @unselect-seat="onUnselectSeat"/>
          </div>
        </div>
      </div>
    </section>

    <!--selected seats-->
    <section v-if="isSeatSelected" class="pt-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <SummarizingRow :total="orderTotalCount" small-text="шт." title="Кількість місць"/>

          <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-5 mt-4">
            <SelectedSeatCard v-for="seat in extendedSelectedSeats" :key="seat.id"
                              :price="seat.price"
                              :row="seat.row_number"
                              :seat="seat.seat_number" :type="seat.type" @remove="removeSeat(seat)"/>
          </div>
        </div>
      </div>
    </section>

    <!--Total price and button-->
    <section v-if="!isPaymentAvailable && isSeatSelected" class="pt-8 pb-6 sm:pb-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto">
          <SummarizingRow :total="orderTotalPrice" small-text="грн" title="Загальна сума"/>

          <PrimaryButton class="sm:text-base mt-4" @click="suggestAuth">
            Підтвердити
          </PrimaryButton>
        </div>
      </div>
    </section>

    <!--Payment section-->
    <PaymentSection v-if="isPaymentAvailable"
                    v-model="orderForm.card_data"
                    :total-price="orderTotalPrice"
                    class="pt-8 sm:pt-12 pb-6 sm:pb-12"
                    @submit="sendStoreOrderRequest"/>

    <!--Auth suggestions modal-->
    <AuthSuggestionModal ref="authSuggestionModalRef"/>
  </MainLayout>
</template>
