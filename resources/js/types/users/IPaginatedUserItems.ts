import type IPagination from '@/types/shared/pagination/IPagination'
import type { IUserItem } from '@/types/users/IUserItem'

export interface IPaginatedUserItems extends IPagination {
  readonly data: Readonly<IUserItem>[]
}
