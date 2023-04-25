<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function store(Request $request)
    {
        Genre::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, Author $author)
    {
        $data = $request->collect()->filter(fn($i) => $i !== null)->toArray();
        $author->update($data);

        return redirect()->back();
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->back();
    }

    public function index()
    {
        return Genre::all();
    }
}
