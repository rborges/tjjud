<?php

namespace App\Domains\Author\Controllers;

use App\Domains\Author\DTO\CreateAuthorDTO;
use App\Domains\Author\DTO\UpdateAuthorDTO;
use App\Domains\Author\Requests\CreateAuthorRequest;
use App\Domains\Author\Requests\UpdateAuthorRequest;
use App\Domains\Author\Services\Contracts\AuthorServiceInterface;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Support\ResponseFormatter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controller responsável pelas operações da entidade Author.
 */
class AuthorController extends Controller
{
    protected AuthorServiceInterface $service;

    /**
     * Injeta a dependência do serviço de autores.
     */
    public function __construct(AuthorServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Retorna todos os autores cadastrados.
     */
    public function index(): JsonResponse
    {
        $authors = $this->service->list();
        return ResponseFormatter::success($authors);
    }

    /**
     * Retorna os dados de um autor específico.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $author = $this->service->get($id);
            return ResponseFormatter::success($author);
        } catch (NotFoundException $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    /**
     * Cria um novo autor com validação.
     */
    public function store(Request $request): JsonResponse
    {
        $dto = CreateAuthorDTO::fromArray(CreateAuthorRequest::validate($request));
        $author = $this->service->create($dto);
        return ResponseFormatter::success($author, 'Autor criado com sucesso', 201);
    }

    /**
     * Atualiza os dados de um autor existente.
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $dto = UpdateAuthorDTO::fromArray(UpdateAuthorRequest::validate($request));

        try {
            $author = $this->service->update($id, $dto);
            return ResponseFormatter::success($author, 'Autor atualizado com sucesso');
        } catch (NotFoundException $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    /**
     * Remove um autor pelo ID.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return ResponseFormatter::success(null, 'Autor excluído com sucesso', 204);
        } catch (NotFoundException $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }
}
