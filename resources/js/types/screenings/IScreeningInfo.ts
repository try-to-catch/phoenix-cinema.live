import type {IHall} from "@/types/hall/IHall";
import type {IMovieDetails} from "@/types/movies/IMovieDetails";

export interface IScreeningInfo {
    readonly id: string;
    start_time: string;
    end_time: string;
    start_date: string;
    start_date_day_of_weak: string;
    standard_seat_price: number;
    premium_seat_price: number;
    hall: IHall;
    movie: IMovieDetails
}
