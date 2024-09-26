<?php

namespace App\Repositories\Contracts;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseRepositoryInterface
{
    public function getAllExpensesByUserId(string $userId): Collection;
    public function create(array $data): Expense;
    public function getById(string $id): Expense;
    public function update(array $data): Expense;
    public function delete(string $id): bool;
}