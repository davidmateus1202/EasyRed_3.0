<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController; // Tu controlador de posts generales

// Nuevos controladores para Grupos
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\GroupMemberController;
use App\Http\Controllers\Api\GroupPostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// --- Autenticación ---
Route::prefix('v1/auth')->group(function () {
   Route::post('/login', [AuthController::class, 'login']);
   Route::post('/register', [AuthController::class, 'register']);
   // Podrías añadir logout, refresh token, etc. aquí
   Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});


// --- Posts Generales (Tu estructura existente) ---
// NOTA: Tenías un '/register' duplicado aquí, lo he comentado. Asumo que es un error.
Route::prefix('v1/posts')->middleware('auth:sanctum')->group(function () { // Cambiado 'post' a 'posts' para ser más RESTful
   Route::post('/', [PostController::class, 'create'])->name('posts.create'); // create -> POST /v1/posts
   Route::get('/', [PostController::class, 'index'])->name('posts.index');    // index -> GET /v1/posts
   Route::post('/{post}/toggle-reaction', [PostController::class, 'toggleReaction'])->name('posts.toggleReaction'); // Asume que {post} es el ID del post
   // Route::post('/register', [AuthController::class, 'register']); // Esto parece un error, ya está en /auth
});


// --- Grupos de Estudio ---
Route::prefix('v1/groups')->middleware('auth:sanctum')->group(function () {

    // Rutas para la gestión de Grupos (CRUD)
    // GET      /v1/groups -> GroupController@index (Listar grupos)
    // POST     /v1/groups -> GroupController@store (Crear grupo)
    // GET      /v1/groups/{group} -> GroupController@show (Mostrar un grupo, {group} es el slug o ID)
    // PUT/PATCH /v1/groups/{group} -> GroupController@update (Actualizar un grupo)
    // DELETE   /v1/groups/{group} -> GroupController@destroy (Eliminar un grupo)
    Route::apiResource('/', GroupController::class)->parameters(['' => 'group']); // Renombrar el parámetro de la ruta base

    // Rutas para Miembros de Grupo
    // GET      /v1/groups/{group}/members -> GroupMemberController@getMembers (Listar miembros de un grupo)
    // POST     /v1/groups/{group}/join -> GroupMemberController@joinGroup (Unirse a un grupo)
    // POST     /v1/groups/{group}/leave -> GroupMemberController@leaveGroup (Abandonar un grupo)
    // Podrías añadir más como:
    // PUT      /v1/groups/{group}/members/{user}/role -> GroupMemberController@updateRole (Cambiar rol)
    // DELETE   /v1/groups/{group}/members/{user} -> GroupMemberController@removeMember (Expulsar miembro)
    Route::get('/{group}/members', [GroupMemberController::class, 'getMembers'])->name('groups.members.index');
    Route::post('/{group}/join', [GroupMemberController::class, 'joinGroup'])->name('groups.join');
    Route::post('/{group}/leave', [GroupMemberController::class, 'leaveGroup'])->name('groups.leave');

    // Rutas para Publicaciones dentro de un Grupo
    // GET      /v1/groups/{group}/posts -> GroupPostController@index (Listar posts de un grupo)
    // POST     /v1/groups/{group}/posts -> GroupPostController@store (Crear post en un grupo)
    Route::get('/{group}/posts', [GroupPostController::class, 'index'])->name('groups.posts.index');
    Route::post('/{group}/posts', [GroupPostController::class, 'store'])->name('groups.posts.store');
});

// Rutas para la gestión individual de Publicaciones de Grupo (editar, eliminar)
// Estas van fuera del prefijo /v1/groups/{group}/posts porque operan sobre un {groupPost} específico.
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('groups', GroupController::class);
    Route::post('groups/{group}/join', [GroupMemberController::class, 'join']);
    Route::post('groups/{group}/leave', [GroupMemberController::class, 'leave']);
    Route::get('groups/{group}/members', [GroupMemberController::class, 'index']);

    Route::get('groups/{group}/posts', [GroupPostController::class, 'index']);
    Route::post('groups/{group}/posts', [GroupPostController::class, 'store']);
});

// Comment routes
Route::prefix('v1/comment')->middleware('auth:sanctum')->group(function () {
   Route::post('/create', [CommentController::class, 'create']);
});
