import type {IPaginationMetaLink} from "@/types/shared/pagination/IPaginationMetaLink";

export interface IPaginationMeta {
    readonly current_page: number;
    readonly from: number;
    readonly last_page: number;
    readonly links: IPaginationMetaLink[];
    readonly path: string;
    readonly per_page: number;
    readonly to: number;
    readonly total: number;

}
