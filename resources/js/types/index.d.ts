import { RoleName } from '@/types/roles/RoleName'

export interface User {
  id: number
  name: string
  email: string
  email_verified_at: string
  roles: Role[]
}

export interface Role {
  id: string
  name: RoleName
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User
  }
  flash: {
    message: { type: 'failure' | 'success'; text: string } | null
  }
}
