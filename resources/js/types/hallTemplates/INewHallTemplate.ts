import type { ISeatType } from '@/types/seats/ISeatType'

export interface INewHallTemplate {
  number: number
  address: string
  is_available: boolean
  seats: ISeatType[][]
}
