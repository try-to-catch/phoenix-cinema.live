export interface ISeat {
    id: string;
    type: SeatType;
    row_number: number;
    seat_number: number;
    is_taken: boolean;
}

export enum SeatType {
    Blank = "blank",
    Standard = "standard",
    Premium = "premium",
}
