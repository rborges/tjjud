<?php

namespace App\Services;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Services\Contracts\BookServiceInterface;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Service responsável pelas regras de negócio da entidade Book.
 */
class BookService implements BookServiceInterface
{
    /**
     * @var BookRepositoryInterface
     */
    protected BookRepositoryInterface $repo;

    /**
     * Injeta a dependência do repositório de livros.
     *
     * @param BookRepositoryInterface $repo
     */
    public function __construct(BookRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Retorna todos os livros cadastrados com suas relações.
     *
     * @return Collection<Book>
     */
    public function list(): Collection
    {
        return $this->repo->all();
    }

    /**
     * Retorna os dados de um livro específico.
     *
     * @param int $id
     * @return Book
     *
     * @throws NotFoundException
     */
    public function get(int $id): Book
    {
        try {
            return $this->repo->find($id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException('Livro não encontrado.');
        }
    }

    /**
     * Cria um novo livro com autores e assuntos vinculados.
     *
     * @param array $data
     * @return Book
     */
    public function create(array $data): Book
    {
        $authorIds = $data['author_ids'] ?? [];
        $subjectIds = $data['subject_ids'] ?? [];

        unset($data['author_ids'], $data['subject_ids']);

        $book = $this->repo->create($data);

        $book->authors()->sync($authorIds);
        $book->subjects()->sync($subjectIds);

        return $book->load(['authors', 'subjects']);
    }

    /**
     * Atualiza os dados de um livro e sincroniza seus relacionamentos.
     *
     * @param int $id
     * @param array $data
     * @return Book
     *
     * @throws NotFoundException
     */
    public function update(int $id, array $data): Book
    {
        try {
            $authorIds = $data['author_ids'] ?? [];
            $subjectIds = $data['subject_ids'] ?? [];

            unset($data['author_ids'], $data['subject_ids']);

            $book = $this->repo->update($id, $data);

            $book->authors()->sync($authorIds);
            $book->subjects()->sync($subjectIds);

            return $book->load(['authors', 'subjects']);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException('Livro não encontrado para atualização.');
        }
    }

    /**
     * Exclui um livro do sistema.
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
            throw new NotFoundException('Livro não encontrado para exclusão.');
        }
    }
}
