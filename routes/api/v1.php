<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function() {

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::apiResources([
        'projects' => ProjectController::class,
        'tasks' => TaskController::class,
        'tags' => TagController::class
    ]);
    
    Route::post('/tasks/{task}/notes', [TaskController::class, 'storeNote']);
    Route::put('/tasks/{task}/notes/{note}', [TaskController::class, 'updateNote']);
    Route::delete('/tasks/{task}/notes/{note}', [TaskController::class, 'destroyNote']);
});
