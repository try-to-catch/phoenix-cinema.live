import type { IGenre } from '@/types/genres/IGenre'

export interface IBanner {
  id: string
  title: string
  slug: string
  start_showing: string
  end_showing: string
  duration: string
  main_cast: string
  production_country: string
  image: string
  description: string
  fact: string
  genres: IGenre[]
}
