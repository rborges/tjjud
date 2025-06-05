<?php

namespace App\Services;

use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Services\Contracts\SubjectServiceInterface;

class SubjectService implements SubjectServiceInterface
{
    protected $repo;

    public function __construct(SubjectRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->all();
    }

    public function get($id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
