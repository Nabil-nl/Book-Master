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

    public function show(Book $book)
    {
        return $book->load('genre');
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

    public function search(Request $request)
    {
        $query = Book::query();

        // Appliquer les filtres de recherche en fonction du titre, de l'auteur ou du genre
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

        // Paginer les résultats
        $books = $query->paginate(10);

        // Vérifier si des livres ont été trouvés
        if ($books->isEmpty()) {
            Log::info('No books found');
            return response()->json(['message' => 'No books found'], 404);
        }

        Log::info('Books found: ' . $books->total()); // Utilisez la méthode total() pour obtenir le nombre total d'éléments paginés
        return response()->json($books, 200);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Delete successfully !!.'], 204);
    }
}
