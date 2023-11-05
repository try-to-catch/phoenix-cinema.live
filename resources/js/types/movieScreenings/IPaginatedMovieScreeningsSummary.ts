import IPagination from '@/types/shared/pagination/IPagination'
import type { IMovieScreeningsSummary } from '@/types/movieScreenings/IMovieScreeningsSummary'

export interface IPaginatedMovieScreeningsSummary extends IPagination {
  data: IMovieScreeningsSummary[]
}
