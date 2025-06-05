<?php

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * Retorna todos os autores.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Author::all();
    }

    /**
     * Retorna um autor pelo ID ou lança ModelNotFoundException.
     *
     * @param int $id
     * @return Author
     *
     * @throws ModelNotFoundException
     */
    public function find($id): Author
    {
        return Author::findOrFail($id);
    }

    /**
     * Cria um novo autor.
     *
     * @param array $data
     * @return Author
     */
    public function create(array $data): Author
    {
        return Author::create($data);
    }

    /**
     * Atualiza os dados de um autor existente.
     *
     * @param int $id
     * @param array $data
     * @return Author
     *
     * @throws ModelNotFoundException
     */
    public function update($id, array $data): Author
    {
        $author = Author::findOrFail($id);
        $author->update($data);

        return $author;
    }

    /**
     * Remove um autor.
     *
     * @param int $id
     * @return bool|null
     *
     * @throws ModelNotFoundException
     */
    public function delete($id): ?bool
    {
        $author = Author::findOrFail($id);
        return $author->delete();
    }
}
