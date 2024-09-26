<?php

namespace App\Services;

use App\Models\Expense;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ExpenseService
{
    public function __construct(
        protected ExpenseRepositoryInterface $repository
    ) {}

    public function getAllExpensesByUserId(string $userId): Collection
    {
        return $this->repository->getAllExpensesByUserId($userId);
    }

    public function create(array $data): Expense
    {
        return $this->repository->create($data);
    }

    public function getById(string $id): Expense
    {
        return $this->repository->getById($id);
    }

    public function update(array $data): Expense
    {
        $expenseId = $data["id"];
        $this->getById($expenseId);
        return $this->repository->update($data);
    }

    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }

}