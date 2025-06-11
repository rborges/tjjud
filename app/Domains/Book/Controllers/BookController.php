<?php

namespace App\Domains\Book\Controllers;

use App\Domains\Book\DTO\CreateBookDTO;
use App\Domains\Book\DTO\UpdateBookDTO;
use App\Domains\Book\Requests\CreateBookRequest;
use App\Domains\Book\Requests\UpdateBookRequest;
use App\Domains\Book\Services\Contracts\BookServiceInterface;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Support\ResponseFormatter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controller responsável pelas operações da entidade Book.
 */
class BookController extends Controller
{
    protected BookServiceInterface $service;

    /**
     * Injeta a dependência do serviço de livros.
     */
    public function __construct(BookServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Retorna todos os livros cadastrados.
     */
    public function index(): JsonResponse
    {
        $books = $this->service->list();
        return ResponseFormatter::success($books);
    }

    /**
     * Retorna os dados de um livro específico.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $book = $this->service->get($id);
            return ResponseFormatter::success($book);
        } catch (NotFoundException $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    /**
     * Cria um novo livro.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = CreateBookRequest::validate($request);
        $book = $this->service->create(CreateBookDTO::fromArray($validated));

        return ResponseFormatter::success($book, 'Livro criado com sucesso', 201);
    }

    /**
     * Atualiza os dados de um livro existente.
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $validated = UpdateBookRequest::validate($request);

        try {
            $book = $this->service->update($id, UpdateBookDTO::fromArray($validated));
            return ResponseFormatter::success($book, 'Livro atualizado com sucesso');
        } catch (NotFoundException $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    /**
     * Remove um livro pelo ID.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return ResponseFormatter::success(null, 'Livro excluído com sucesso', 204);
        } catch (NotFoundException $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }
}
