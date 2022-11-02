<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function index(): Collection
    {
        return Book::all();
    }

    public function store(Request $request): Book
    {
        $request->validate([
           'title' => ['required']
        ]);

        $book = new Book();

        $book->title = $request->input('title');
        $book->save();

        return $book;
    }

    public function show(Book $book): Book
    {
        return $book;
    }

    public function update(Request $request, Book $book): Book
    {
        $request->validate([
            'title' => ['required']
        ]);

        $book->title = $request->input('title');
        $book->save();

        return $book;
    }

    public function destroy(Book $book): Response
    {
        $book->delete();

        return response()->noContent();
    }
}
