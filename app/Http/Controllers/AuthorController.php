<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Contracts\AuthorServiceInterface;
use App\Exceptions\NotFoundException;

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
        try {
            $author = $this->service->get($id);
            return response()->json($author);
        } catch (NotFoundException $e) {
            return response()->json(['error' => 'Autor não encontrado'], 404);
        }
    }

    /**
     * Cadastra um novo autor.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40',
            'book_ids' => 'sometimes|array',
            'book_ids.*' => 'integer|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $author = $this->service->create($validator->validated());

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $author = $this->service->update($id, $validator->validated());
            return response()->json($author);
        } catch (NotFoundException $e) {
            return response()->json(['error' => 'Autor não encontrado'], 404);
        }
    }

    /**
     * Remove um autor.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(null, 204);
        } catch (NotFoundException $e) {
            return response()->json(['error' => 'Autor não encontrado'], 404);
        }
    }
}
