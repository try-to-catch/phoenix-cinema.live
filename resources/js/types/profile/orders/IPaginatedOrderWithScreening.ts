import type IPagination from '@/types/shared/pagination/IPagination'
import type { IOrderWithScreening } from '@/types/profile/orders/IOrderWithScreening'

export interface IPaginatedOrderWithScreening extends IPagination {
  readonly data: Readonly<IOrderWithScreening>[]
}
