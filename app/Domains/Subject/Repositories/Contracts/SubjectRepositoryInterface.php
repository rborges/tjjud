<?php

namespace App\Domains\Subject\Repositories\Contracts;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

interface SubjectRepositoryInterface
{
    /**
     * Retorna todos os assuntos.
     *
     * @return Collection<Subject>
     */
    public function all(): Collection;

    /**
     * Retorna um assunto pelo ID.
     *
     * @param int $id
     * @return Subject
     */
    public function find(int $id): Subject;

    /**
     * Cria um novo assunto.
     *
     * @param array $data
     * @return Subject
     */
    public function create(array $data): Subject;

    /**
     * Atualiza um assunto existente.
     *
     * @param int $id
     * @param array $data
     * @return Subject
     */
    public function update(int $id, array $data): Subject;

    /**
     * Remove um assunto pelo ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;
}
