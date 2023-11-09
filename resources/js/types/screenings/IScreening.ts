import type { IMovieTitleAndId } from '@/types/movies/IMovieTitleAndId'
import type { IHall } from '@/types/hall/IHall'

export interface IScreening {
  readonly id: string
  start_time: string
  end_time: string
  standard_seat_price: number
  premium_seat_price: number
  readonly movie: IMovieTitleAndId
  readonly hall: IHall
}
