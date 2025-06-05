<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        $authors = [
            ['name' => 'João Silva'],
            ['name' => 'Maria Oliveira'],
            ['name' => 'Carlos Souza'],
            ['name' => 'Ana Lima'],
            ['name' => 'Fernanda Rocha'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
