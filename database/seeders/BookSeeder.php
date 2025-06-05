<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                'title' => 'Laravel Essencial',
                'publisher' => 'Editora Tech',
                'edition' => 1,
                'published_year' => '2020',
                'price' => 120.00,
                'authors' => [1, 2], // dois autores
                'subjects' => [1, 2],
            ],
            [
                'title' => 'PHP Moderno',
                'publisher' => 'Code House',
                'edition' => 2,
                'published_year' => '2021',
                'price' => 99.90,
                'authors' => [3],
                'subjects' => [1, 3],
            ],
            [
                'title' => 'História do Brasil',
                'publisher' => 'Educação Plus',
                'edition' => 1,
                'published_year' => '2019',
                'price' => 80.00,
                'authors' => [4],
                'subjects' => [2],
            ],
            [
                'title' => 'Lógica Matemática',
                'publisher' => 'Cálculo Editora',
                'edition' => 3,
                'published_year' => '2018',
                'price' => 110.50,
                'authors' => [1],
                'subjects' => [3, 5],
            ],
            [
                'title' => 'Pensamento Filosófico',
                'publisher' => 'Editora Saber',
                'edition' => 1,
                'published_year' => '2022',
                'price' => 130.00,
                'authors' => [5],
                'subjects' => [5],
            ],
        ];

        foreach ($books as $data) {
            $book = Book::create([
                'title' => $data['title'],
                'publisher' => $data['publisher'],
                'edition' => $data['edition'],
                'published_year' => $data['published_year'],
                'price' => $data['price'],
            ]);

            $book->authors()->attach($data['authors']);
            $book->subjects()->attach($data['subjects']);
        }
    }
}
