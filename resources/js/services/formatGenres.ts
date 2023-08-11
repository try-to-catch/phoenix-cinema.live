import type {IGenre} from "@/types/genres/IGenre";

export function formatGenres(genres: IGenre[]) {
    return genres.map((genre) => {
        return genre.name;
    }).join(', ');
}
