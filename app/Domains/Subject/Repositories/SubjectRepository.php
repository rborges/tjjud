<?php

namespace App\Domains\Subject\Repositories;

use App\Domains\Subject\Repositories\Contracts\SubjectRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repositório responsável pelas operações de persistência da entidade Subject.
 */
class SubjectRepository implements SubjectRepositoryInterface
{
    /**
     * Retorna todos os assuntos.
     *
     * @return Collection<Subject>
     */
    public function all(): Collection
    {
        return Subject::with('books')->get();
    }

    /**
     * Retorna um assunto pelo ID.
     *
     * @param int $id
     * @return Subject
     *
     * @throws NotFoundException
     */
    public function find(int $id): Subject
    {
        $subject = Subject::with('books')->find($id);

        if (!$subject) {
            throw new NotFoundException('Assunto não encontrado.');
        }

        return $subject;
    }

    /**
     * Cria um novo assunto.
     *
     * @param array $data
     * @return Subject
     */
    public function create(array $data): Subject
    {
        $subject = Subject::create([
            'description' => $data['description'],
        ]);

        if (!empty($data['book_ids'])) {
            $subject->books()->sync($data['book_ids']);
        }

        return $subject->load('books');
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
        $subject = Subject::find($id);

        if (!$subject) {
            throw new NotFoundException('Assunto não encontrado para atualização.');
        }

        $subject->update([
            'description' => $data['description'],
        ]);

        if (isset($data['book_ids'])) {
            $subject->books()->sync($data['book_ids']);
        }

        return $subject->load('books');
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
        $subject = Subject::find($id);

        if (!$subject) {
            throw new NotFoundException('Assunto não encontrado para exclusão.');
        }

        return $subject->delete();
    }
}
