<?php

use App\Http\Middleware\CheckQueryTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {  
    return Inertia\Inertia::render('Index');  
});

Route::get('/login', function () {  
    return Inertia\Inertia::render('Login');  
});

Route::get('/businesses', function () {  
    return Inertia\Inertia::render('Businesses');  
});

Route::get('/businesses/create', function () {  
    return Inertia\Inertia::render('CreateEditBusiness');  
});

Route::get('/businesses/{id}', function (int $id) {  
    return Inertia\Inertia::render('CreateEditBusiness', ['id' => $id]);  
});

Route::get('/categories', function () {  
    return Inertia\Inertia::render('Categories');  
});

Route::get('/categories/create', function () {  
    return Inertia\Inertia::render('CreateEditCategory');  
});

Route::get('/categories/{id}', function (int $id) {  
    return Inertia\Inertia::render('CreateEditCategory', ['id' => $id]);  
});

Route::get('/peoples', function () {  
    return Inertia\Inertia::render('People');  
});

Route::get('/peoples/create', function () {  
    return Inertia\Inertia::render('CreateEditPeople');  
});

Route::get('/peoples/{id}', function (int $id) {  
    return Inertia\Inertia::render('CreateEditPeople', ['id' => $id]);  
});

Route::get('/tags', function () {  
    return Inertia\Inertia::render('Tags');  
});

Route::get('/tags/create', function () {  
    return Inertia\Inertia::render('CreateEditTag');  
});

Route::get('/tags/{id}', function (int $id) {  
    return Inertia\Inertia::render('CreateEditTag', ['id' => $id]);  
});

Route::get('/tasks', function () {  
    return Inertia\Inertia::render('Tasks');  
});

Route::get('/tasks/create', function () {  
    return Inertia\Inertia::render('CreateEditTask');  
});

Route::get('/tasks/{id}', function (int $id) {  
    return Inertia\Inertia::render('CreateEditTask', ['id' => $id]);  
});

Route::get('/unauthenticated', function () {
    return view('unauthenticated');
});
