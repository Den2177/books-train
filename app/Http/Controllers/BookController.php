<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->has('image')) {
            $image = $request->file('image');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $name);
            $data['image'] = '/public/images/' . $name;
        }

        $genres = [];

        if (isset($data['genres'])) {
            $genres = $data['genres'];
            unset($data['genres']);
        }
        $book = Book::create($data);
        $book->genres()->attach($genres);

        return redirect()->back();
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->collect()->filter(fn($i) => $i !== null)->toArray();

        if ($request->file('image')) {
            $image = $request->file('image');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $name);
            $data['image'] = '/public/images/' . $name;
        }

        $genres = [];

        if (isset($data['genres'])) {
            $genres = $data['genres'];
            unset($data['genres']);
        }

        $book->update($data);

        if (count($genres)) {
            $book->genres()->sync($genres);
        }

        return redirect()->back();
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->back();
    }

    public function index()
    {
        $books = Book::all()->map(function ($book) {
            $book->avgScores = $book->scores()->avg('value') ?? 0;
            return $book;
        });

        if (request('scoreFrom') || request('scoreTo')) {
            $books = $books->filter(fn($book) => $book->avgScores >= request('scoreFrom') && $book->avgScores <= request('scoreTo'));
        }

        if (request('author_id')) {
            $books = $books->filter(fn($book) => $book->author_id == request('author_id'));
        }

        if (request('genres')) {
            $books = $books->filter(function ($book) {
                $genres = collect(explode(',', request('genres')));
                return $book->genres->map(fn($g) => (string) $g->id)->intersect($genres)->count();
            });
        }


        if (request('sort')) {
            if (request('sort') === 'date-up') {
                $books = $books->sortBy('created_at');
            } else if (request('sort') === 'date-down') {
                $books = $books->sortByDesc('created_at');
            } else if (request('sort') === 'score-up') {
                $books = $books->sortBy('avgScores');
            } else if (request('sort') === 'score-down') {
                $books = $books->sortByDesc('avgScores');
            }
        }

        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        /*        collect($book)->merge([
                    'author' => Author::find($book->author_id),
                    'genres' => $book->genres,
                    'scores' => $book->scores->map
                ])*/
        return new BookResource($book);
    }

    public function like(Book $book)
    {
        if (auth()->user()->books()->where('books.id', $book->id)->exists()) {
            auth()->user()->books()->detach($book->id);
        } else {
            auth()->user()->books()->attach($book->id);
        }

        return [
            'success' => true,
        ];
    }

    public function getLiked()
    {
        return auth()->user()->books;
    }

    public function setScore(Book $book, Request $request)
    {
        Score::create([
            'value' => request('value'),
            'user_id' => auth()->user()->id,
            'book_id' => $book->id,
        ]);

        return [
            'success' => true,
        ];
    }

    public function maySet(Book $book)
    {
        return [
            'result' => auth()->check() && !auth()->user()->scores->map(fn($b) => $b->book_id)->contains($book->id),
        ];
    }
}
