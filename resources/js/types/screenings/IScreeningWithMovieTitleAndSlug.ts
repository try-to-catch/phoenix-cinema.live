import type { IMovieTitleAndSlug } from '@/types/movies/IMovieTitleAndSlug'

export interface IScreeningWithMovieTitleAndSlug {
  readonly id: string
  start_time: string
  movie: IMovieTitleAndSlug
}
