<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'publication_year' => 'required|integer',
            'isbn' => 'required|string|max:13',
            'copies_available' => 'required|integer',
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function show(Book $book)
    {
        return $book;
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'genre' => 'sometimes|required|string|max:255',
            'publication_year' => 'sometimes|required|integer',
            'isbn' => 'sometimes|required|string|max:13',
            'copies_available' => 'sometimes|required|integer',
        ]);

        $book->update($request->all());

        return response()->json($book, 200);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Delete  successfully !!.'], 204);
    }
}
