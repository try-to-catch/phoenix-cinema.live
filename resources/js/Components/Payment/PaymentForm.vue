<script lang="ts" setup>
import NumberInput from "@/Components/Breeze/NumberInput.vue";
import SummarizingRow from "@/Components/Payment/SummarizingRow.vue";
import PrimaryButton from "@/Components/Breeze/PrimaryButton.vue";
import H5Title from "@/Components/Titles/H5Title.vue";
import usePayment from "@/composables/payment";
import CardNumberInput from "@/Components/Payment/CardNumberInput.vue";
import CvvCodeInput from "@/Components/Payment/CvvCodeInput.vue";

defineProps<{
    totalPrice: number
}>()

const currentYear = new Date().getFullYear()

const {form} = usePayment()

const processPayment = () => {
    console.log('payment')
}
</script>

<template>
    <form @submit.prevent="processPayment">
        <H5Title>Оплата</H5Title>

        <!--request card number, expire date and cvv code-->
        <form class="mt-4">
            <CardNumberInput v-model="form.cardNumber" required/>

            <div class="grid grid-cols-3 gap-4 mt-4">
                <NumberInput id="expire_month" v-model.trim="form.expireMonth" :max="12" :min="1" label-inner="Місяць"
                             required/>
                <NumberInput id="expire_year" v-model.trim="form.expireYear" :max="currentYear + 10" :min="currentYear"
                             label-inner="Рік" required/>

                <CvvCodeInput v-model="form.cvvCode" required/>
            </div>
        </form>

        <div class="mt-8">
            <SummarizingRow :total="totalPrice" small-text="грн" title="Загальна сума"/>

            <PrimaryButton class="sm:text-base mt-4">
                Сплатити
            </PrimaryButton>
        </div>
    </form>
</template>
