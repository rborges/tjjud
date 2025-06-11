<?php

namespace App\Domains\Author\Repositories;

use App\Domains\Author\Repositories\Contracts\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Repositório responsável pelas operações de persistência da entidade Author.
 */
class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * Retorna todos os autores com seus livros.
     *
     * @return Collection<Author>
     */
    public function all(): Collection
    {
        return Author::with('books')->get();
    }

    /**
     * Retorna um autor pelo ID com seus livros.
     *
     * @param int $id
     * @return Author
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id): Author
    {
        return Author::with('books')->findOrFail($id);
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
    public function update(int $id, array $data): Author
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
    public function delete(int $id): ?bool
    {
        $author = Author::findOrFail($id);
        return $author->delete();
    }
}
