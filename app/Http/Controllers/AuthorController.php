<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        Author::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, Author $author)
    {
        $data = $request->collect()->filter(fn($i) => $i !== null)->toArray();
        $author->update($data);

        return redirect()->back();
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->back();
    }

    public function index()
    {
        return Author::all();
    }
}
