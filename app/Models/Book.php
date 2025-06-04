<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'publisher',
        'edition',
        'published_year',
    ];

    // Livro tem muitos autores (N:N)
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    // Livro tem muitos assuntos (N:N)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'book_subject');
    }
}
