<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('/books', [\App\Http\Controllers\BookController::class, 'index']);
Route::get('/books/{book}/show', [\App\Http\Controllers\BookController::class, 'show']);
Route::get('/authors', [\App\Http\Controllers\AuthorController::class, 'index']);
Route::get('/genres', [\App\Http\Controllers\GenreController::class, 'index']);
Route::get('/filtered-books', [\App\Http\Controllers\BookController::class, 'filteredIndex']);


Route::middleware(\App\Http\Middleware\AuthCheck::class)->group(function() {
    Route::get('/books/{book}/like', [\App\Http\Controllers\BookController::class, 'like']);
    Route::get('/liked', [\App\Http\Controllers\BookController::class, 'getLiked']);
    Route::post('/books/{book}/set-score', [\App\Http\Controllers\BookController::class, 'setScore']);
    Route::get('/books/{book}/may-set', [\App\Http\Controllers\BookController::class, 'maySet']);
});
