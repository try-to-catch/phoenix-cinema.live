import { RoleName } from '@/types/roles/RoleName'

export interface IUserItem {
  readonly id: string
  email: string
  name: string
  orders_count: number
  roles: RoleName[]
}
