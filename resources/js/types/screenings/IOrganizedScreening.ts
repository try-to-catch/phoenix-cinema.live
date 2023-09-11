import type { IOrganizedScreeningItem } from '@/types/screenings/IOrganizedScreeningItem'

export interface IOrganizedScreening {
  date: string
  screenings: IOrganizedScreeningItem[]
}
