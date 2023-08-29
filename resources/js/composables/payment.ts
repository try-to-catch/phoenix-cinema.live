import {useForm} from "@inertiajs/vue3";
import type {ICardData} from "@/types/payments/ICardData";
import {watchEffect} from "vue";

const form = useForm<ICardData>({
    cardNumber: null,
    expireMonth: null,
    expireYear: null,
    cvvCode: '',
})

const currentYear = new Date().getFullYear()
watchEffect(() => {

    if (form.expireYear && !(form.expireYear.toString().length <= 4)) {
        form.expireYear = parseInt(form.expireYear.toString().slice(0, 4))
    } else if (form.expireYear && form.expireYear.toString().length === 4) {
        if (form.expireYear < currentYear) {
            form.expireYear = currentYear
        } else if (form.expireYear > currentYear + 10) {
            form.expireYear = currentYear + 10
        }
    }
})

watchEffect(() => {
    if (form.expireMonth && !(form.expireMonth.toString().length <= 2)) {
        form.expireMonth = parseInt(form.expireMonth.toString().slice(0, 2))
    } else if (form.expireMonth && form.expireMonth.toString().length === 2) {
        if (form.expireMonth < 1) {
            form.expireMonth = 1
        } else if (form.expireMonth > 12) {
            form.expireMonth = 12
        }
    }
})
export default function usePayment() {
    return {form}
}
