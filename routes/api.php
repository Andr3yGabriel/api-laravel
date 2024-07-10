<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/register', [UserController::class, 'register']); // POST - http://127.0.0.1:8000/api/register
Route::post('/login', [UserController::class, 'login']); // POST - http://127.0.0.1:8000/api/login
Route::get('/users', [UserController::class, 'index']); // GET - http://127.0.0.1:8000/api/users?page=1

// Rotas protegidas por autenticação
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/{user}', [UserController::class, 'show']); // GET - http://127.0.0.1:8000/api/users/1
    Route::put('/users/{user}', [UserController::class, 'update']); // PUT - http://127.0.0.1:8000/api/users/1
    Route::delete('/users/{user}', [UserController::class, 'destroy']); // DELETE - http://127.0.0.1:8000/api/users/1

    // Rotas de tarefas
    Route::get('/tasks', [TaskController::class, 'show']); // GET - http://127.0.0.1:8000/api/tasks?page=1
    Route::post('/tasks', [TaskController::class, 'store']); // POST - http://127.0.0.1:8000/api/tasks
});
