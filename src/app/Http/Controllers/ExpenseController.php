<?php

namespace App\Http\Controllers;

use App\Http\Requests\Expenses\StoreUpdateRequest;
use App\Http\Resources\ExpenseResource;
use App\Services\ExpenseService;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * @param ExpenseService $service
     */
    public function __construct(
        protected ExpenseService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $expenses = $this->service->getAllExpensesByUserId($userId);
        return ExpenseResource::collection($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateRequest $request): ExpenseResource
    {
        // Merge expense data sent from request with user data (can be a DTO in the future) 
        $expenseRequest = array_merge(
            ['user_id' => $request->user()->id],
            $request->only('description', 'amount', 'date')
        );

        $expense = $this->service->create($expenseRequest);
        return new ExpenseResource($expense);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = $this->service->getById($id);
        // Check if the user has access to this expense
        if(Auth::user()->cannot('view', $expense)) {
            return response()->json(['message'=> 'You do not have permission to view this expense'], 403);
        }

        return new ExpenseResource($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateRequest $request, string $id)
    {
        $expenseToBeUpdated = $this->service->getById($id);
        // Check if user has authorization to update the expense passed
        if($request->user()->cannot('update', $expenseToBeUpdated)) {
            return response()->json(['message'=> 'You do not have permission to update this expense'], 403);
        }

        // Set user data sent from request (can be a DTO in the future)
        $userData = array_merge(
            ['id' => $id], 
            $request->only('description', 'amount', 'date')
        );

        $userUpdated = $this->service->update($userData);
        return new ExpenseResource($userUpdated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expenseToBeDeleted = $this->service->getById($id);
        // Check if user has authorization to update the expense passed
        if(Auth::user()->cannot('delete', $expenseToBeDeleted)) {
            return response()->json(['message'=> 'You do not have permission to delete this expense'], 403);
        }

        if ($this->service->delete($id)) return response()->json([], 204);

        return response()->json([],500);
    }
}
