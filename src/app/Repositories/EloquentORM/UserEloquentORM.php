<?php

namespace App\Repositories\EloquentORM;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserEloquentORM implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) {}

    public function getAll(): Collection
    {
        $users = $this->model->all();
        return $users;
    }

    public function create(array $data): User
    {
        $user = $this->model->create($data);
        return $user;
    }

    public function getById(string $id): User
    {
        $user = $this->model->findOrFail($id);
        return $user;
    }

    public function update(array $data): User
    {
        $userId = $data["id"];
        $user = $this->getById(id: $userId);
        $user->update($data);
        return $user;
    }
    
    public function delete(string $id): bool
    {
        $user = $this->getById($id);
        return $user->delete();
    }
}