<?php

namespace App\Domains\Author\Services;

use App\Domains\Author\DTO\CreateAuthorDTO;
use App\Domains\Author\DTO\UpdateAuthorDTO;
use App\Domains\Author\Repositories\Contracts\AuthorRepositoryInterface;
use App\Domains\Author\Services\Contracts\AuthorServiceInterface;
use App\Exceptions\NotFoundException;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Service responsável pelas regras de negócio da entidade Author.
 */
class AuthorService implements AuthorServiceInterface
{
    protected AuthorRepositoryInterface $repo;

    /**
     * Injeta a dependência do repositório de autores.
     *
     * @param AuthorRepositoryInterface $repo
     */
    public function __construct(AuthorRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Retorna todos os autores cadastrados.
     *
     * @return Collection<Author>
     */
    public function list(): Collection
    {
        return $this->repo->all();
    }

    /**
     * Retorna os dados de um autor específico.
     *
     * @param int $id
     * @return Author
     *
     * @throws NotFoundException
     */
    public function get(int $id): Author
    {
        try {
            return $this->repo->find($id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException('Autor não encontrado.');
        }
    }

    /**
     * Cria um novo autor com livros vinculados.
     *
     * @param CreateAuthorDTO $dto
     * @return Author
     */
    public function create(CreateAuthorDTO $dto): Author
    {
        $author = $this->repo->create($dto->toArray());

        if (!empty($dto->book_ids)) {
            $author->books()->sync($dto->book_ids);
        }

        return $author->load('books');
    }

    /**
     * Atualiza os dados de um autor.
     *
     * @param int $id
     * @param UpdateAuthorDTO $dto
     * @return Author
     *
     * @throws NotFoundException
     */
    public function update(int $id, UpdateAuthorDTO $dto): Author
    {
        try {
            $author = $this->repo->find($id);
            $author->update($dto->toArray());

            return $author;
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException('Autor não encontrado para atualização.');
        }
    }

    /**
     * Remove um autor pelo ID.
     *
     * @param int $id
     * @return bool|null
     *
     * @throws NotFoundException
     */
    public function delete(int $id): ?bool
    {
        try {
            return $this->repo->delete($id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException('Autor não encontrado para exclusão.');
        }
    }
}
