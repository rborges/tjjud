<?php

namespace App\Services\Contracts;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

interface SubjectServiceInterface
{
    /**
     * Retorna a lista de assuntos cadastrados.
     *
     * @return Collection<Subject>
     */
    public function list(): Collection;

    /**
     * Retorna os dados de um assunto específico pelo ID.
     *
     * @param int $id
     * @return Subject
     */
    public function get(int $id): Subject;

    /**
     * Cria um novo assunto com os dados fornecidos.
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
