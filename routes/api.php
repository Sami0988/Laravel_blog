<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\UserController;



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

// Public routes
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);

// Protected routes 
Route::middleware('auth:api')->group(function () {
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});

//comment route 

Route::middleware('auth:api')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
});

Route::get('/posts/{post}/comments', [CommentController::class, 'show']);

//my-post route
Route::middleware('auth:api')->get('/my-posts', [PostController::class, 'myPosts']);


//Admin Only 
Route::middleware(['auth:api', 'useradmin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
    Route::get('/admin/user-stats', [UserController::class, 'report']);
});