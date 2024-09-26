<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}


    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function create(array $data): User
    {
        return $this->repository->create($data);
    }

    public function getById(string $id): User
    {
        return $this->repository->getById($id);
    }

    public function update(array $data): User
    {
        $userId = $data["id"];
        $this->getById($userId);
        return $this->repository->update($data);
    }

    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }

}