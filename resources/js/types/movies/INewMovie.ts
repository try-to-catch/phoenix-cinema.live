import type { INewBanner } from '@/types/banners/INewBanner'

export interface INewMovie {
  title: string
  description: string
  director: string
  production_country: string
  main_cast: string
  genres: string[]
  priority: number | null
  duration_in_minutes: number | null
  age_restriction: string
  thumbnail: File | null | string
  release_year: number | null
  original_title: string | null
  studio: string | null
  start_showing: string | null
  end_showing: string | null
  banner: INewBanner | null
}
