import type {IPaginationLinks} from "@/types/shared/pagination/IPaginationLinks";
import type {IPaginationMeta} from "@/types/shared/pagination/IPaginationMeta";

export default interface IPagination {
    data: any[];
    links: IPaginationLinks;
    meta: IPaginationMeta;
}
