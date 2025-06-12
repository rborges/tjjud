<?php

namespace App\Domains\Subject\Services;

use App\Domains\Subject\DTO\CreateSubjectDTO;
use App\Domains\Subject\DTO\UpdateSubjectDTO;
use App\Domains\Subject\Repositories\Contracts\SubjectRepositoryInterface;
use App\Domains\Subject\Services\Contracts\SubjectServiceInterface;
use App\Exceptions\NotFoundException;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Service responsável pelas regras de negócio da entidade Subject.
 */
class SubjectService implements SubjectServiceInterface
{
    protected SubjectRepositoryInterface $repo;

    /**
     * Injeta a dependência do repositório de assuntos.
     */
    public function __construct(SubjectRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Retorna todos os assuntos cadastrados.
     *
     * @return Collection<Subject>
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
     * Cria um novo assunto com livros vinculados.
     *
     * @param CreateSubjectDTO $dto
     * @return Subject
     */
    public function create(CreateSubjectDTO $dto): Subject
    {
        $subject = $this->repo->create([
            'description' => $dto->description,
        ]);

        if (!empty($dto->book_ids)) {
            $subject->books()->sync($dto->book_ids);
        }

        return $subject->load('books');
    }

    /**
     * Atualiza os dados de um assunto.
     *
     * @param int $id
     * @param UpdateSubjectDTO $dto
     * @return Subject
     * @throws NotFoundException
     */
    public function update(int $id, UpdateSubjectDTO $dto): Subject
    {
        try {
            $subject = $this->repo->update($id, [
                'description' => $dto->description,
            ]);

            if (!empty($dto->book_ids)) {
                $subject->books()->sync($dto->book_ids);
            }

            return $subject->load('books');
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException('Assunto não encontrado para atualização.');
        }
    }

    /**
     * Remove um assunto pelo ID.
     *
     * @param int $id
     * @return bool|null
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
