<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Support\Str;

class ComicSeeder extends Seeder
{
    public function run(): void
    {
        // Удаляем добавленные ранее 6 комиксов вместе со связанными записями
        $removeSlugs = ['the-sandman', 'maus', 'v-for-vendetta', 'saga', 'sin-city', 'hellboy'];
        $removeIds = Comic::whereIn('slug', $removeSlugs)->pluck('id')->all();

        if (!empty($removeIds)) {
            if (Schema::hasTable('order_items')) {
                DB::table('order_items')->whereIn('comic_id', $removeIds)->delete();
            }
            if (Schema::hasTable('reviews')) {
                DB::table('reviews')->whereIn('comic_id', $removeIds)->delete();
            }
            if (Schema::hasTable('comic_genre')) {
                DB::table('comic_genre')->whereIn('comic_id', $removeIds)->delete();
            }
            Comic::whereIn('id', $removeIds)->delete();
        }

        // Удаляем лишние жанры
        Genre::whereIn('name', ['Фэнтези', 'Хоррор', 'Приключения', 'Биография'])->delete();

        $genreNames = ['Супергерои', 'Боевик', 'Драма', 'Детектив', 'Фантастика', 'Триллер'];
        $genres = [];
        foreach ($genreNames as $name) {
            $genres[$name] = Genre::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'slug' => Str::slug($name)]
            );
        }

        $items = [
            [
                'slug' => 'batman-year-one',
                'title' => 'Бэтмен: Первый год',
                'author' => 'Фрэнк Миллер',
                'price' => 399.00,
                'published_year' => 1987,
                'pages_count' => 96,
                'description' => 'История о том, как Брюс Уэйн становится Бэтменом, а молодой Джеймс Гордон приходит в коррумпированную полицию Готэма. Мрачный нуар-детектив о первом годе борьбы с преступностью.',
                'genres' => ['Супергерои', 'Детектив', 'Боевик'],
            ],
            [
                'slug' => 'spider-man-blue',
                'title' => 'Человек-паук: Синева',
                'author' => 'Джеф Лоэб',
                'price' => 349.00,
                'published_year' => 2002,
                'pages_count' => 144,
                'description' => 'Трогательная история-воспоминание Питера Паркера о его первой любви — Гвен Стейси. Лиричный рассказ о юности, утрате и взрослении Человека-паука.',
                'genres' => ['Супергерои', 'Драма'],
            ],
            [
                'slug' => 'watchmen',
                'title' => 'Хранители',
                'author' => 'Алан Мур',
                'price' => 599.00,
                'published_year' => 1986,
                'pages_count' => 416,
                'description' => 'Культовый графический роман об отставных супергероях в альтернативной Америке на грани ядерной войны. Глубокая деконструкция жанра и размышление о морали и власти.',
                'genres' => ['Супергерои', 'Триллер', 'Фантастика'],
            ],
        ];

        foreach ($items as $i) {
            $comic = Comic::updateOrCreate(
                ['slug' => $i['slug']],
                [
                    'title' => $i['title'],
                    'author' => $i['author'],
                    'description' => $i['description'],
                    'price' => $i['price'],
                    'pdf_path' => 'comics/demo.pdf',
                    'pages_count' => $i['pages_count'],
                    'published_year' => $i['published_year'],
                    'is_active' => true,
                ]
            );

            $ids = [];
            foreach ($i['genres'] as $gName) {
                $ids[] = $genres[$gName]->id;
            }
            $comic->genres()->sync($ids);
        }
    }
}
