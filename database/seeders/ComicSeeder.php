<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comic;
use Illuminate\Support\Str;

class ComicSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Batman: Year One', 'price' => 399.00, 'published_year' => 1987, 'pages_count' => 96],
            ['title' => 'Spider-Man: Blue', 'price' => 349.00, 'published_year' => 2002, 'pages_count' => 144],
            ['title' => 'Watchmen', 'price' => 599.00, 'published_year' => 1986, 'pages_count' => 416],
        ];

        foreach ($items as $i) {
            $slug = Str::slug($i['title']);
            Comic::firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $i['title'],
                    'slug' => $slug,
                    'description' => 'Описание будет добавлено администратором.',
                    'price' => $i['price'],
                    'pdf_path' => 'private/comics/demo.pdf',
                    'pages_count' => $i['pages_count'],
                    'published_year' => $i['published_year'],
                    'is_active' => true,
                ]
            );
        }
    }
}
