import type { IGenre } from '@/types/genres/IGenre'

export interface IMovieCard {
  readonly id: string
  title: string
  readonly slug: string
  thumbnail: string
  age_restriction: string
  director: string
  start_showing: string
  end_showing: string
  genres: IGenre[]
}
