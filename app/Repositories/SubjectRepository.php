<?php

namespace App\Repositories;

use App\Models\Subject;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\NotFoundException;

/**
 * Repositório responsável pelas operações de persistência da entidade Subject.
 */
class SubjectRepository implements SubjectRepositoryInterface
{
    /**
     * Retorna todos os assuntos com seus livros relacionados.
     *
     * @return Collection<Subject>
     */
    public function all(): Collection
    {
        return Subject::with('books')->get();
    }

    /**
     * Retorna um assunto específico pelo ID com seus livros.
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
            throw new NotFoundException("Assunto não encontrado");
        }

        return $subject;
    }

    /**
     * Cria um novo assunto e vincula os livros relacionados.
     *
     * @param array $data
     * @return Subject
     */
    public function create(array $data): Subject
    {
        $subject = Subject::create($data);

        if (!empty($data['book_ids'])) {
            $subject->books()->sync($data['book_ids']);
        }

        return $subject->load('books');
    }

    /**
     * Atualiza os dados de um assunto existente.
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
            throw new NotFoundException("Assunto não encontrado");
        }

        $subject->update($data);

        if (!empty($data['book_ids'])) {
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
            throw new NotFoundException("Assunto não encontrado");
        }

        return $subject->delete();
    }
}
