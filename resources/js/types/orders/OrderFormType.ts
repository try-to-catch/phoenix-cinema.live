/** Inertia's useForm doesn't work correctly with interfaces */
import type {ICardData} from "@/types/payments/ICardData";

export type OrderFormType = {
    seat_ids: string[];
    card_data: ICardData;
}
