<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::prefix('v1/auth')->group(function () {
   Route::post('/login', [AuthController::class, 'login']); 
   Route::post('/register', [AuthController::class, 'register']);
});

Route::prefix('v1/post')->middleware('auth:sanctum')->group(function () {
   Route::post('/create', [PostController::class, 'create']);
   Route::get('/index', [PostController::class, 'index']);
   Route::post('/toggle-reaction', [PostController::class, 'toggleReaction']);
   Route::post('/register', [AuthController::class, 'register']);
});

// Comment routes
Route::prefix('v1/comment')->middleware('auth:sanctum')->group(function () {
   Route::post('/create', [CommentController::class, 'create']);
});
