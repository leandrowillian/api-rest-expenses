<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

interface UserRepositoryInterface
{
    public function getAll(): Collection;
    public function create(array $data): User;
    public function getById(string $id): User;
    public function update(array $data): User;
    public function delete(string $id): bool;
}