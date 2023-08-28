import {useForm} from "@inertiajs/vue3";
import type {ICardData} from "@/types/payments/ICardData";
import {watchEffect} from "vue";

const form = useForm<ICardData>({
    cardNumber: '1231',
    expireMonth: null,
    expireYear: null,
    cvvCode: null,
})

watchEffect(() => {
    if (form.cvvCode && !(form.cvvCode.toString().length <= 3)) {
        form.cvvCode = parseInt(form.cvvCode.toString().slice(0, 3))
    }
})

export default function usePayment() {
    return {form}
}
