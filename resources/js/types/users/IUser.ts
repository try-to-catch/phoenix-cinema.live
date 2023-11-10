import type { RoleName } from '@/types/roles/RoleName'

export interface IUser {
  readonly id: string
  name: string
  email: string
  roles: RoleName[]
}
