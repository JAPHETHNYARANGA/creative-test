<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

// Default route to login page
Route::get('/', function () {
    return view('login');
});

// Route to register page
Route::get('register', function () {
    return view('register');
});

// Route to posts page
Route::get('posts', function () {
    return view('posts');
});

// Authentication routes
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

// Post routes (protected by authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('posts', [PostsController::class, 'index'])->name('posts.index');
    Route::post('posts', [PostsController::class, 'store'])->name('posts.store');
    Route::get('posts/{id}', [PostsController::class, 'show'])->name('posts.show');
    Route::get('/posts/{id}/edit', [PostsController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{id}', [PostsController::class, 'update'])->name('posts.update');
    Route::delete('posts/{id}', [PostsController::class, 'destroy'])->name('posts.destroy');
});
