<?php

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function all()
    {
        return Author::all();
    }
    public function find($id)
    {
        return Author::findOrFail($id);
    }
    public function create(array $data)
    {
        return Author::create($data);
    }
    public function update($id, array $data)
    {
        $author = Author::findOrFail($id);
        $author->update($data);
        return $author;
    }
    public function delete($id)
    {
        $author = Author::findOrFail($id);
        return $author->delete();
    }
}
