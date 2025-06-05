<?php

namespace App\Services;

use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Services\Contracts\AuthorServiceInterface;
use App\Exceptions\NotFoundException;

class AuthorService implements AuthorServiceInterface
{
    protected AuthorRepositoryInterface $repo;

    /**
     * @param AuthorRepositoryInterface $repo
     */
    public function __construct(AuthorRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Retorna a lista de todos os autores.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return $this->repo->all();
    }

    /**
     * Retorna os dados de um autor específico.
     *
     * @param int $id
     * @return \App\Models\Author
     *
     * @throws NotFoundException
     */
    public function get($id)
    {
        try {
            return $this->repo->find($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new NotFoundException('Autor não encontrado.');
        }
    }

    /**
     * Cria um novo autor e relaciona livros, se fornecidos.
     *
     * @param array $data
     * @return \App\Models\Author
     */
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

    /**
     * Atualiza os dados de um autor existente.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Author
     *
     * @throws NotFoundException
     */
    public function update($id, array $data)
    {
        try {
            $author = $this->repo->find($id);
            $author->update($data);
            return $author;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
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
    public function delete($id)
    {
        try {
            return $this->repo->delete($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new NotFoundException('Autor não encontrado para exclusão.');
        }
    }
}
