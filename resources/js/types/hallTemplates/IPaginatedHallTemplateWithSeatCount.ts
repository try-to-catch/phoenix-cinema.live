import type IPagination from '@/types/shared/pagination/IPagination'
import type { IHallTemplateWithSeatCount } from '@/types/hallTemplates/IHallTemplateWithSeatCount'

export interface IPaginatedHallTemplateWithSeatCount extends IPagination {
  readonly data: Readonly<IHallTemplateWithSeatCount>[]
}
