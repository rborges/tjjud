<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Contracts\AuthorServiceInterface;
use App\Helpers\ValidatorHelper;

/**
 * Class AuthorController
 *
 * Controlador responsável pelas operações CRUD de autores.
 */
class AuthorController extends Controller
{
    protected AuthorServiceInterface $service;

    /**
     * AuthorController constructor.
     *
     * @param AuthorServiceInterface $service
     */
    public function __construct(AuthorServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Lista todos os autores.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    /**
     * Retorna os dados de um autor específico.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->get($id));
    }

    /**
     * Cadastra um novo autor.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = ValidatorHelper::validate($request->all(), [
            'name' => 'required|string|max:40',
            'book_ids' => 'sometimes|array',
            'book_ids.*' => 'integer|exists:books,id',
        ])->validated();

        $author = $this->service->create($validated);
        return response()->json($author, 201);
    }

    /**
     * Atualiza os dados de um autor.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $validated = ValidatorHelper::validate($request->all(), [
            'name' => 'required|string|max:40',
        ])->validated();

        $author = $this->service->update($id, $validated);
        return response()->json($author);
    }

    /**
     * Remove um autor.
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
