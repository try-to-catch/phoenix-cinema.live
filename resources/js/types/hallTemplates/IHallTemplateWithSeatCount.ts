import type { IHallTemplateEssentials } from '@/types/hallTemplates/IHallTemplateEssentials'

export interface IHallTemplateWithSeatCount extends IHallTemplateEssentials {
  readonly id: string
  readonly seats_count: string
}
