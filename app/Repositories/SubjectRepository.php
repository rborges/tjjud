<?php

namespace App\Repositories;

use App\Models\Subject;
use App\Repositories\Contracts\SubjectRepositoryInterface;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function all()
    {
        return Subject::with('books')->get();
    }

    public function find($id)
    {
        return Subject::with('books')->findOrFail($id);
    }

    public function create(array $data)
    {
        $subject = Subject::create($data);
        if (isset($data['book_ids'])) {
            $subject->books()->sync($data['book_ids']);
        }
        return $subject->load('books');
    }

    public function update($id, array $data)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($data);
        if (isset($data['book_ids'])) {
            $subject->books()->sync($data['book_ids']);
        }
        return $subject->load('books');
    }

    public function delete($id)
    {
        $subject = Subject::findOrFail($id);
        return $subject->delete();
    }
}
