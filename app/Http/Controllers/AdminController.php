<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        $genres = Genre::all();
        $books = Book::all();
        $users = User::all();

        return view('admin', compact('authors', 'books', 'genres', 'users'));
    }
}
