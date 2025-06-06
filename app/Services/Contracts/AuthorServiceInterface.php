<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Author;

interface AuthorServiceInterface
{
    /**
     * Retorna a lista de todos os autores.
     *
     * @return Collection<Author>
     */
    public function list(): Collection;

    /**
     * Retorna os dados de um autor específico.
     *
     * @param int $id
     * @return Author
     */
    public function get(int $id): Author;

    /**
     * Cria um novo autor.
     *
     * @param array $data
     * @return Author
     */
    public function create(array $data): Author;

    /**
     * Atualiza os dados de um autor existente.
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
