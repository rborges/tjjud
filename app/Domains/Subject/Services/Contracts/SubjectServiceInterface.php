<?php

namespace App\Domains\Subject\Services\Contracts;

use App\Domains\Subject\DTO\CreateSubjectDTO;
use App\Domains\Subject\DTO\UpdateSubjectDTO;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

interface SubjectServiceInterface
{
    /**
     * Retorna todos os assuntos cadastrados.
     *
     * @return Collection<Subject>
     */
    public function list(): Collection;

    /**
     * Retorna os dados de um assunto específico.
     *
     * @param int $id
     * @return Subject
     */
    public function get(int $id): Subject;

    /**
     * Cria um novo assunto com os dados do DTO.
     *
     * @param CreateSubjectDTO $dto
     * @return Subject
     */
    public function create(CreateSubjectDTO $dto): Subject;

    /**
     * Atualiza os dados de um assunto existente.
     *
     * @param int $id
     * @param UpdateSubjectDTO $dto
     * @return Subject
     */
    public function update(int $id, UpdateSubjectDTO $dto): Subject;

    /**
     * Exclui um assunto do sistema.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;
}
