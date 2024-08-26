<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [AuthenticationController::class,'register']);

Route::post('login', [AuthenticationController::class,'login']);


// Post routes (protected by authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('posts', [PostsController::class, 'index']);
    Route::post('posts', [PostsController::class, 'store']);
    Route::get('posts/{id}', [PostsController::class, 'show']);
    Route::put('posts/{id}', [PostsController::class, 'update']);
    Route::delete('posts/{id}', [PostsController::class, 'destroy']);
});


