import type { IMovieTitleAndSlug } from '@/types/movies/IMovieTitleAndSlug'

export interface IScreeningWithMovieTitleAndSlug {
  readonly id: string
  startTime: string
  movie: IMovieTitleAndSlug
}
