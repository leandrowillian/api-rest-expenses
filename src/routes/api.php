<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Login Route
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get("/", function () {
    return 'root';
});

Route::apiResource('/users', UserController::class);