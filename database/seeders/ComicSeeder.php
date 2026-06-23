<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Support\Str;

class ComicSeeder extends Seeder
{
    public function run(): void
    {
        $genreNames = ['Супергерои', 'Боевик', 'Драма', 'Детектив', 'Фантастика', 'Триллер', 'Фэнтези', 'Хоррор', 'Приключения', 'Биография'];
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
            [
                'slug' => 'the-sandman',
                'title' => 'Песочный человек',
                'author' => 'Нил Гейман',
                'price' => 649.00,
                'published_year' => 1989,
                'pages_count' => 3000,
                'description' => 'Сага о Морфее — повелителе снов, одном из семи Вечных. Завораживающее переплетение мифологии, фэнтези и хоррора о природе историй и судьбы.',
                'genres' => ['Фэнтези', 'Драма', 'Хоррор'],
            ],
            [
                'slug' => 'maus',
                'title' => 'Маус',
                'author' => 'Арт Шпигельман',
                'price' => 549.00,
                'published_year' => 1991,
                'pages_count' => 296,
                'description' => 'Удостоенный Пулитцеровской премии графический роман о Холокосте, где евреи изображены мышами, а нацисты — котами. Пронзительный рассказ отца автора о выживании.',
                'genres' => ['Драма', 'Биография'],
            ],
            [
                'slug' => 'v-for-vendetta',
                'title' => 'V — значит вендетта',
                'author' => 'Алан Мур',
                'price' => 479.00,
                'published_year' => 1988,
                'pages_count' => 296,
                'description' => 'В тоталитарной Британии будущего загадочный анархист в маске Гая Фокса по имени V начинает революцию против диктатуры. Острая антиутопия о свободе и бунте.',
                'genres' => ['Фантастика', 'Триллер', 'Боевик'],
            ],
            [
                'slug' => 'saga',
                'title' => 'Сага',
                'author' => 'Брайан К. Вон',
                'price' => 529.00,
                'published_year' => 2012,
                'pages_count' => 1400,
                'description' => 'Космическая опера о паре с враждующих планет, которые спасают новорождённую дочь посреди бесконечной галактической войны. Смесь фантастики, фэнтези и семейной драмы.',
                'genres' => ['Фантастика', 'Приключения', 'Драма'],
            ],
            [
                'slug' => 'sin-city',
                'title' => 'Город грехов',
                'author' => 'Фрэнк Миллер',
                'price' => 499.00,
                'published_year' => 1991,
                'pages_count' => 208,
                'description' => 'Жёсткий чёрно-белый нуар о преступном Городе грехов: продажные копы, наёмники и роковые женщины. Брутальные переплетённые истории о мести и насилии.',
                'genres' => ['Детектив', 'Боевик', 'Триллер'],
            ],
            [
                'slug' => 'hellboy',
                'title' => 'Хеллбой',
                'author' => 'Майк Миньола',
                'price' => 459.00,
                'published_year' => 1994,
                'pages_count' => 400,
                'description' => 'Демон, призванный нацистами, но ставший защитником человечества, расследует паранормальные угрозы. Атмосферный микс хоррора, фольклора и приключений.',
                'genres' => ['Хоррор', 'Приключения', 'Фэнтези'],
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
