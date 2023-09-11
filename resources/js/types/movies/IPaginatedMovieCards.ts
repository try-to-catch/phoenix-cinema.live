import type { IMovieCard } from '@/types/movies/IMovieCard'
import type IPagination from '@/types/shared/pagination/IPagination'

export interface IPaginatedMovieCards extends IPagination {
  readonly data: Readonly<IMovieCard>[]
}
