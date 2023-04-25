<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index']);

Route::post('/admin/books', [\App\Http\Controllers\BookController::class, 'store'])->name('books.store');
Route::post('/admin/authors', [\App\Http\Controllers\AuthorController::class, 'store'])->name('authors.store');
Route::post('/admin/genres', [\App\Http\Controllers\GenreController::class, 'store'])->name('genres.store');

Route::patch('/admin/{author}/authors', [\App\Http\Controllers\AuthorController::class, 'update'])->name('authors.update');
Route::patch('/admin/{genre}/genres', [\App\Http\Controllers\GenreController::class, 'update'])->name('genres.update');
Route::patch('/admin/{book}/books', [\App\Http\Controllers\BookController::class, 'update'])->name('books.update');
Route::patch('/admin/{user}/users', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');

Route::get('/admin/{author}/authors/delete', [\App\Http\Controllers\AuthorController::class, 'destroy'])->name('authors.destroy');
Route::get('/admin/{genre}/genres/delete', [\App\Http\Controllers\GenreController::class, 'destroy'])->name('genres.destroy');
Route::get('/admin/{book}/books/delete', [\App\Http\Controllers\BookController::class, 'destroy'])->name('books.destroy');
Route::get('/admin/{user}/users/delete', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

Route::post('/admin/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');

Route::get('/{route}', function () {
    return view('default');
})->where('route', '.*');
