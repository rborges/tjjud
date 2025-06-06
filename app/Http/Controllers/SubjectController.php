<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Contracts\SubjectServiceInterface;
use App\Helpers\ValidatorHelper;
use App\Exceptions\NotFoundException;

/**
 * Controller responsável pelas operações de CRUD de assuntos.
 */
class SubjectController extends Controller
{
    /**
     * @var SubjectServiceInterface
     */
    protected SubjectServiceInterface $service;

    /**
     * Injeta o serviço de assuntos.
     *
     * @param SubjectServiceInterface $service
     */
    public function __construct(SubjectServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Lista todos os assuntos.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    /**
     * Retorna um assunto específico pelo ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->service->get($id));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Cria um novo assunto.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = ValidatorHelper::validate($request->all(), [
            'description' => 'required|string|max:20',
            'book_ids' => 'array',
            'book_ids.*' => 'integer|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $subject = $this->service->create($validated);
        return response()->json($subject, 201);
    }

    /**
     * Atualiza um assunto existente.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $validator = ValidatorHelper::validate($request->all(), [
            'description' => 'required|string|max:20',
            'book_ids' => 'array',
            'book_ids.*' => 'integer|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $validated = $validator->validated();
            $subject = $this->service->update($id, $validated);
            return response()->json($subject);
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove um assunto.
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
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
