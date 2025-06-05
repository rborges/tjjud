<?php

namespace App\Services;

use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Services\Contracts\SubjectServiceInterface;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

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
     */
    public function get(int $id): Subject
    {
        return $this->repo->find($id);
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
     */
    public function update(int $id, array $data): Subject
    {
        return $this->repo->update($id, $data);
    }

    /**
     * Remove um assunto pelo ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        return $this->repo->delete($id);
    }
}
