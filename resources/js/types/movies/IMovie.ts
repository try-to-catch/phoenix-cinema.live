import { IGenre } from '@/types/genres/IGenre'

export interface IMovie {
  readonly id: string
  title: string
  original_title: string
  readonly slug: string
  description: string
  duration: string
  age_restriction: string
  thumbnail: string
  release_year: number
  director: string
  production_country: string
  studio: string
  main_cast: string
  start_showing: string
  end_showing: string
  genres: IGenre[]
}
