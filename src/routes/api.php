<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Login Route
Route::post('/login', [LoginController::class, 'authenticate']);
// Create User Route
Route::post('/users', [UserController::class,'store']);
// Auth Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class)->except('store');
    Route::apiResource('/expenses', ExpenseController::class);
});