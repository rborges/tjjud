<?php

namespace App\Services;

use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Services\Contracts\AuthorServiceInterface;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Author;

/**
 * Serviço responsável pelas regras de negócio relacionadas à entidade Author.
 */
class AuthorService implements AuthorServiceInterface
{
    /**
     * @var AuthorRepositoryInterface
     */
    protected AuthorRepositoryInterface $repo;

    /**
     * Injeta o repositório de autores.
     *
     * @param AuthorRepositoryInterface $repo
     */
    public function __construct(AuthorRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Retorna a lista de todos os autores.
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
     * Cria um novo autor e relaciona livros, se fornecidos.
     *
     * @param array $data
     * @return Author
     */
    public function create(array $data): Author
    {
        $author = $this->repo->create([
            'name' => $data['name'],
        ]);

        if (!empty($data['book_ids'])) {
            $author->books()->sync($data['book_ids']);
        }

        return $author->load('books');
    }

    /**
     * Atualiza os dados de um autor existente.
     *
     * @param int $id
     * @param array $data
     * @return Author
     *
     * @throws NotFoundException
     */
    public function update(int $id, array $data): Author
    {
        try {
            $author = $this->repo->find($id);
            $author->update($data);

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
