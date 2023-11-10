import { RoleName } from '@/types/roles/RoleName'
import type { IEditForm } from '@/types/shared/forms/IEditForm'

export interface IUserEditForm extends IEditForm {
  roles: RoleName[]
}
