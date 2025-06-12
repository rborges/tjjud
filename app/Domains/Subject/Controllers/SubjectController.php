<?php

namespace App\Domains\Subject\Controllers;

use App\Domains\Subject\DTO\CreateSubjectDTO;
use App\Domains\Subject\DTO\UpdateSubjectDTO;
use App\Domains\Subject\Requests\CreateSubjectRequest;
use App\Domains\Subject\Requests\UpdateSubjectRequest;
use App\Domains\Subject\Services\Contracts\SubjectServiceInterface;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Support\ResponseFormatter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controller responsável pelas operações da entidade Subject.
 */
class SubjectController extends Controller
{
    protected SubjectServiceInterface $service;

    /**
     * Injeta a dependência do serviço de assuntos.
     */
    public function __construct(SubjectServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Retorna todos os assuntos cadastrados.
     */
    public function index(): JsonResponse
    {
        $subjects = $this->service->list();
        return ResponseFormatter::success($subjects);
    }

    /**
     * Retorna os dados de um assunto específico.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $subject = $this->service->get($id);
            return ResponseFormatter::success($subject);
        } catch (NotFoundException $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    /**
     * Cria um novo assunto com validação e DTO.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = CreateSubjectRequest::validate($request);
        $dto = CreateSubjectDTO::fromArray($validated);
        $subject = $this->service->create($dto);

        return ResponseFormatter::success($subject, 'Assunto criado com sucesso', 201);
    }

    /**
     * Atualiza um assunto existente.
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $validated = UpdateSubjectRequest::validate($request);
        $dto = UpdateSubjectDTO::fromArray($validated);

        try {
            $subject = $this->service->update($id, $dto);
            return ResponseFormatter::success($subject, 'Assunto atualizado com sucesso');
        } catch (NotFoundException $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    /**
     * Remove um assunto pelo ID.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return ResponseFormatter::success(null, 'Assunto excluído com sucesso', 204);
        } catch (NotFoundException $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }
}
