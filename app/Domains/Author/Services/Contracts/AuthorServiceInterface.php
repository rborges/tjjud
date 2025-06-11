<?php

namespace App\Domains\Author\Services\Contracts;

use App\Domains\Author\DTO\CreateAuthorDTO;
use App\Domains\Author\DTO\UpdateAuthorDTO;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

interface AuthorServiceInterface
{
    /**
     * Retorna todos os autores cadastrados.
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
     * @param CreateAuthorDTO $dto
     * @return Author
     */
    public function create(CreateAuthorDTO $dto): Author;

    /**
     * Atualiza os dados de um autor existente.
     *
     * @param int $id
     * @param UpdateAuthorDTO $dto
     * @return Author
     */
    public function update(int $id, UpdateAuthorDTO $dto): Author;

    /**
     * Remove um autor.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;
}
