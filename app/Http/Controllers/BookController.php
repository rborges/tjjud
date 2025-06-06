<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Contracts\BookServiceInterface;
use App\Http\Requests\BookValidator;

/**
 * Controller responsável pelas operações da entidade Book.
 */
class BookController extends Controller
{
    /**
     * @var BookServiceInterface
     */
    protected BookServiceInterface $service;

    /**
     * Injeta a dependência do serviço de livros.
     *
     * @param BookServiceInterface $service
     */
    public function __construct(BookServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Retorna todos os livros cadastrados.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    /**
     * Retorna os dados de um livro específico.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->get($id));
    }

    /**
     * Cria um novo livro a partir dos dados validados.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = BookValidator::validate($request->all())->validated();
        $book = $this->service->create($validated);
        return response()->json($book, 201);
    }

    /**
     * Atualiza os dados de um livro existente.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $validated = BookValidator::validate($request->all())->validated();
        $book = $this->service->update($id, $validated);
        return response()->json($book);
    }

    /**
     * Remove um livro pelo ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
