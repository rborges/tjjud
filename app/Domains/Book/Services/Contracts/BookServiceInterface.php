<?php

namespace App\Domains\Book\Services\Contracts;

use App\Domains\Book\DTO\CreateBookDTO;
use App\Domains\Book\DTO\UpdateBookDTO;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

interface BookServiceInterface
{
    /**
     * Retorna a lista de todos os livros cadastrados.
     *
     * @return Collection<Book>
     */
    public function list(): Collection;

    /**
     * Retorna os dados de um livro específico.
     *
     * @param int $id
     * @return Book
     */
    public function get(int $id): Book;

    /**
     * Cria um novo livro.
     *
     * @param CreateBookDTO $dto DTO com os dados do livro a ser criado
     * @return Book
     */
    public function create(CreateBookDTO $dto): Book;

    /**
     * Atualiza um livro com dados encapsulados em DTO.
     *
     * @param int $id
     * @param UpdateBookDTO $dto
     * @return Book
     */
    public function update(int $id, UpdateBookDTO $dto): Book;

    /**
     * Exclui um livro.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;
}
