<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $popularGenres = [
            "Екшн", "Пригоди", "Комедія", "Драма", "Романтика", "Наукова фантастика", "Фентезі",
            "Трилер", "Жахи", "Детектив", "Кримінал", "Мультфільм", "Сімейний", "Документальний", "Історичний",
            "Воєнний", "Вестерн", "Мюзикл", "Спорт", "Біографічний", "Музичний", "Аніме", "Бойовик",
            "Експериментальний", "Короткометражний", "Містика",
        ];

        foreach ($popularGenres as $genre) {
            Genre::create(["name" => $genre]);
        }
    }
}
