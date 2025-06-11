<?php

namespace App\Domains\Book\Services;

use App\Domains\Book\DTO\CreateBookDTO;
use App\Domains\Book\DTO\UpdateBookDTO;
use App\Domains\Book\Repositories\Contracts\BookRepositoryInterface;
use App\Domains\Book\Services\Contracts\BookServiceInterface;
use App\Models\Book;
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
     * @param CreateBookDTO $dto DTO com os dados do livro
     * @return Book
     */
    public function create(CreateBookDTO $dto): Book
    {
        $book = $this->repo->create([
            'title' => $dto->title,
            'publisher' => $dto->publisher,
            'edition' => $dto->edition,
            'published_year' => $dto->published_year,
            'price' => $dto->price,
        ]);

        $book->authors()->sync($dto->author_ids);
        $book->subjects()->sync($dto->subject_ids);

        return $book->load(['authors', 'subjects']);
    }

    /**
     * Atualiza os dados de um livro e sincroniza seus relacionamentos.
     *
     * @param int $id
     * @param UpdateBookDTO $dto
     * @return Book
     *
     * @throws NotFoundException
     */
    public function update(int $id, UpdateBookDTO $dto): Book
    {
        try {
            $book = $this->repo->update($id, $dto->toArray());

            $book->authors()->sync($dto->author_ids);
            $book->subjects()->sync($dto->subject_ids);

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
