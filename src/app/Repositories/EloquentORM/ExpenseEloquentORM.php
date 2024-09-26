<?php

namespace App\Repositories\EloquentORM;

use App\Models\Expense;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ExpenseEloquentORM implements ExpenseRepositoryInterface
{
    public function __construct(
        protected Expense $model
    ) {}

    public function getAllExpensesByUserId(string $userId): Collection
    {
        $expenses = $this->model->where(
            "user_id",
            $userId
        )->get();
        
        return $expenses;
    }

    public function create(array $data): Expense
    {
        $expense = $this->model->create($data);
        return $expense;
    }

    public function getById(string $id): Expense
    {
        $expense = $this->model->findOrFail($id);
        return $expense;
    }

    public function update(array $data): Expense
    {
        $expenseId = $data["id"];
        $expense = $this->getById(id: $expenseId);
        $expense->update($data);
        return $expense;
    }
    
    public function delete(string $id): bool
    {
        $expense = $this->getById($id);
        return $expense->delete();
    }
}