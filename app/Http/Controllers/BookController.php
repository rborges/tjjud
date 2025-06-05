<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\BookServiceInterface;
use App\Http\Requests\BookValidator;
use Illuminate\Http\JsonResponse;
use App\Exceptions\NotFoundException;

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
    public function show($id): JsonResponse
    {
        try {
            return response()->json($this->service->get($id));
        } catch (NotFoundException $e) {
            return response()->json(['error' => 'Livro não encontrado.'], 404);
        }
    }

    /**
     * Cria um novo livro a partir dos dados validados.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = BookValidator::validate($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $book = $this->service->create($request->all());

        return response()->json($book, 201);
    }

    /**
     * Atualiza os dados de um livro existente.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $validator = BookValidator::validate($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $book = $this->service->update($id, $request->all());
            return response()->json($book);
        } catch (NotFoundException $e) {
            return response()->json(['error' => 'Livro não encontrado.'], 404);
        }
    }

    /**
     * Remove um livro pelo ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(null, 204);
        } catch (NotFoundException $e) {
            return response()->json(['error' => 'Livro não encontrado.'], 404);
        }
    }
}
