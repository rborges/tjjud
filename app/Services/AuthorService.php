<?php

namespace App\Services;

use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Services\Contracts\AuthorServiceInterface;

class AuthorService implements AuthorServiceInterface
{
    protected $repo;

    public function __construct(AuthorRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->all();
    }

    public function get($id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        $author = $this->repo->create([
            'name' => $data['name'],
        ]);

        if (!empty($data['book_ids'])) {
            $author->books()->sync($data['book_ids']);
        }

        return $author->load('books');
    }


    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
