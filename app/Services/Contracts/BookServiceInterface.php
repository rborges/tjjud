<?php

namespace App\Services\Contracts;

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
     * @param array $data
     * @return Book
     */
    public function create(array $data): Book;

    /**
     * Atualiza os dados de um livro.
     *
     * @param int $id
     * @param array $data
     * @return Book
     */
    public function update(int $id, array $data): Book;

    /**
     * Exclui um livro.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;
}
