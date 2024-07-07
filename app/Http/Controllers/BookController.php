<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'genre_id' => 'required|exists:genres,id',
            'publication_year' => 'required|integer',
            'isbn' => 'required|string|max:13|unique:books,isbn',
            'copies_available' => 'required|integer',
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function show(Request $request, $id = null)
    {
        if ($id) {
            // Find the book by ID
            $book = Book::find($id);

            // Check if $book is null (model not found)
            if (!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            }

            // Load relationships if needed
            $book->load('genre');

            return response()->json($book, 200);
        } else {
            // Handle search based on query parameters
            Log::info('Search request received', $request->all());

            $query = Book::query();

            // Apply search filters based on title, author, or genre_id
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->input('title') . '%');
                Log::info('Searching by title: ' . $request->input('title'));
            }

            if ($request->has('author')) {
                $query->where('author', 'like', '%' . $request->input('author') . '%');
                Log::info('Searching by author: ' . $request->input('author'));
            }

            if ($request->has('genre_id')) {
                $query->where('genre_id', $request->input('genre_id'));
                Log::info('Searching by genre_id: ' . $request->input('genre_id'));
            }

            // Log the final query
            Log::info('Final query: ' . $query->toSql(), $query->getBindings());

            // Paginate the results
            $books = $query->paginate(10);

            // Check if any books were found
            if ($books->isEmpty()) {
                Log::info('No books found for query: ' . $query->toSql(), $query->getBindings());
                return response()->json(['message' => 'No books found'], 404);
            }

            Log::info('Books found: ' . $books->total());
            return response()->json($books, 200);
        }
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'genre_id' => 'sometimes|required|exists:genres,id',
            'publication_year' => 'sometimes|required|integer',
            'isbn' => 'sometimes|required|string|max:13|unique:books,isbn,' . $book->id,
            'copies_available' => 'sometimes|required|integer',
        ]);

        $book->update($request->all());

        return response()->json($book, 200);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully.'], 204);
    }
}
