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
        $genreNames = ['Супергерои', 'Боевик', 'Драма', 'Детектив', 'Фантастика', 'Триллер'];
        $genres = [];
        foreach ($genreNames as $name) {
            $genres[$name] = Genre::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'slug' => Str::slug($name)]
            );
        }

        $items = [
            ['title' => 'Batman: Year One', 'price' => 399.00, 'published_year' => 1987, 'pages_count' => 96, 'genres' => ['Супергерои', 'Детектив', 'Боевик']],
            ['title' => 'Spider-Man: Blue', 'price' => 349.00, 'published_year' => 2002, 'pages_count' => 144, 'genres' => ['Супергерои', 'Драма']],
            ['title' => 'Watchmen', 'price' => 599.00, 'published_year' => 1986, 'pages_count' => 416, 'genres' => ['Супергерои', 'Триллер', 'Фантастика']],
        ];

        foreach ($items as $i) {
            $slug = Str::slug($i['title']);
            $comic = Comic::firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $i['title'],
                    'slug' => $slug,
                    'description' => 'Описание будет добавлено администратором.',
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
            $comic->genres()->syncWithoutDetaching($ids);
        }
    }
}
