<?php

namespace App\Domains\Book\Repositories;

use App\Models\Book;
use App\Domains\Book\Repositories\Contracts\BookRepositoryInterface;
use App\Exceptions\NotFoundException;

/**
 * Repositório responsável pelas operações de persistência da entidade Book.
 */
class BookRepository implements BookRepositoryInterface
{
    /**
     * Retorna todos os livros com autores e assuntos.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Book::with(['authors', 'subjects'])->get();
    }

    /**
     * Retorna um livro pelo ID.
     *
     * @param int $id
     * @return Book
     *
     * @throws NotFoundException
     */
    public function find($id)
    {
        $book = Book::with(['authors', 'subjects'])->find($id);

        if (!$book) {
            throw new NotFoundException('Livro não encontrado.');
        }

        return $book;
    }

    /**
     * Cria um novo livro.
     *
     * @param array $data
     * @return Book
     */
    public function create(array $data)
    {
        return Book::create($data);
    }

    /**
     * Atualiza os dados de um livro existente.
     *
     * @param int $id
     * @param array $data
     * @return Book
     *
     * @throws NotFoundException
     */
    public function update($id, array $data)
    {
        $book = Book::find($id);

        if (!$book) {
            throw new NotFoundException('Livro não encontrado para atualização.');
        }

        $book->update($data);
        return $book;
    }

    /**
     * Exclui um livro pelo ID.
     *
     * @param int $id
     * @return bool|null
     *
     * @throws NotFoundException
     */
    public function delete($id)
    {
        $book = Book::find($id);

        if (!$book) {
            throw new NotFoundException('Livro não encontrado para exclusão.');
        }

        return $book->delete();
    }
}
