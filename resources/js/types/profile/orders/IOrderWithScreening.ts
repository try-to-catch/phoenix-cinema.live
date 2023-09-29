import type { IScreeningWithMovieTitleAndSlug } from '@/types/screenings/IScreeningWithMovieTitleAndSlug'

export interface IOrderWithScreening {
  readonly id: string
  screening: IScreeningWithMovieTitleAndSlug
  readonly seat_count: number
  readonly isCompleted: boolean
  readonly created_at: string
}
