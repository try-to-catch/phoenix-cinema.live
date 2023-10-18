export interface ITableItem {
  id: string
  thumbnail?: string

  [key: string]: string | number | boolean | string[] | number[] | undefined
}
