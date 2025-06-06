<?php

namespace App\Services;

use App\Models\Subject;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Services\Contracts\SubjectServiceInterface;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Service responsável pelas regras de negócio da entidade Subject.
 */
class SubjectService implements SubjectServiceInterface
{
    protected SubjectRepositoryInterface $repo;

    public function __construct(SubjectRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Retorna todos os assuntos cadastrados.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->repo->all();
    }

    /**
     * Retorna os dados de um assunto específico.
     *
     * @param int $id
     * @return Subject
     *
     * @throws NotFoundException
     */
    public function get(int $id): Subject
    {
        try {
            return $this->repo->find($id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException('Assunto não encontrado.');
        }
    }

    /**
     * Cria um novo assunto.
     *
     * @param array $data
     * @return Subject
     */
    public function create(array $data): Subject
    {
        return $this->repo->create($data);
    }

    /**
     * Atualiza um assunto existente.
     *
     * @param int $id
     * @param array $data
     * @return Subject
     *
     * @throws NotFoundException
     */
    public function update(int $id, array $data): Subject
    {
        try {
            return $this->repo->update($id, $data);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException('Assunto não encontrado para atualização.');
        }
    }

    /**
     * Remove um assunto pelo ID.
     *
     * @param int $id
     * @return bool|null
     *
     * @throws NotFoundException
     */
    public function delete(int $id): ?bool
    {
        try {
            return $this->repo->delete($id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException('Assunto não encontrado para exclusão.');
        }
    }
}
