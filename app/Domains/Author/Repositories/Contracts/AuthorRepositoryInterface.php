<?php

namespace App\Domains\Author\Repositories\Contracts;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

interface AuthorRepositoryInterface
{
    /**
     * Retorna todos os autores com seus livros relacionados.
     *
     * @return Collection<Author>
     */
    public function all(): Collection;

    /**
     * Retorna um autor específico pelo ID com seus livros.
     *
     * @param int $id
     * @return Author
     */
    public function find(int $id): Author;

    /**
     * Cria um novo autor.
     *
     * @param array $data
     * @return Author
     */
    public function create(array $data): Author;

    /**
     * Atualiza um autor existente.
     *
     * @param int $id
     * @param array $data
     * @return Author
     */
    public function update(int $id, array $data): Author;

    /**
     * Remove um autor pelo ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;
}
