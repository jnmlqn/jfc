<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::get('/businesses', [App\Http\Controllers\BusinessesController::class, 'index']);
    Route::get('/businesses/{id}', [App\Http\Controllers\BusinessesController::class, 'read']);
    Route::post('/businesses', [App\Http\Controllers\BusinessesController::class, 'create']);
    Route::put('/businesses/{id}', [App\Http\Controllers\BusinessesController::class, 'update']);
    Route::delete('/businesses/{id}', [App\Http\Controllers\BusinessesController::class, 'delete']);

    Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index']);
    Route::get('/categories/{id}', [App\Http\Controllers\CategoriesController::class, 'read']);
    Route::post('/categories', [App\Http\Controllers\CategoriesController::class, 'create']);
    Route::put('/categories/{id}', [App\Http\Controllers\CategoriesController::class, 'update']);
    Route::delete('/categories/{id}', [App\Http\Controllers\CategoriesController::class, 'delete']);

    Route::get('/peoples', [App\Http\Controllers\PeopleController::class, 'index']);
    Route::get('/peoples/{id}', [App\Http\Controllers\PeopleController::class, 'read']);
    Route::post('/peoples', [App\Http\Controllers\PeopleController::class, 'create']);
    Route::put('/peoples/{id}', [App\Http\Controllers\PeopleController::class, 'update']);
    Route::delete('/peoples/{id}', [App\Http\Controllers\PeopleController::class, 'delete']);

    Route::get('/tags', [App\Http\Controllers\TagsController::class, 'index']);
    Route::get('/tags/{id}', [App\Http\Controllers\TagsController::class, 'read']);
    Route::post('/tags', [App\Http\Controllers\TagsController::class, 'create']);
    Route::put('/tags/{id}', [App\Http\Controllers\TagsController::class, 'update']);
    Route::delete('/tags/{id}', [App\Http\Controllers\TagsController::class, 'delete']);

    Route::get('/tasks', [App\Http\Controllers\TasksController::class, 'index']);
    Route::get('/tasks/{id}', [App\Http\Controllers\TasksController::class, 'read']);
    Route::post('/tasks', [App\Http\Controllers\TasksController::class, 'create']);
    Route::put('/tasks/{id}', [App\Http\Controllers\TasksController::class, 'update']);
    Route::delete('/tasks/{id}', [App\Http\Controllers\TasksController::class, 'delete']);
});
