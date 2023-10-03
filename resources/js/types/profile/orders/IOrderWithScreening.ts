import type { IScreeningWithMovieTitleAndSlug } from '@/types/screenings/IScreeningWithMovieTitleAndSlug'

export interface IOrderWithScreening {
  readonly id: string
  screening: IScreeningWithMovieTitleAndSlug
  readonly seatsCount: number
  readonly isCompleted: boolean
  readonly showDate: string
}
