<?php

namespace App\Services\Contracts;

interface SubjectServiceInterface
{
    public function list();
    public function get($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
