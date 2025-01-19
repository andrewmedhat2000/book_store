<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = $this->bookService->createBook($validated);

        return response()->json([
            'message' => 'book created successfully!',
            'book' => $book
        ], 201);
     }

    public function index(Request $request)
    {
        $books = $this->bookService->getAllBooks($request->all());
        return response()->json($books);
    }

    public function show($id)
    {
        $book = $this->bookService->getBookById($id);
        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'author_id' => 'sometimes|required|exists:authors,id',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $book = $this->bookService->updateBook($id, $validated);

        return response()->json([
            'message' => 'book updated successfully!',
            'book' => $book
        ]);
    }

    public function destroy($id)
    {
        $this->bookService->deleteBook($id);
        return response()->json(['message' => 'Book deleted successfully']);
    }

    public function trashed()
    {
        $trashedBooks = $this->bookService->getTrashedBooks();
        return response()->json($trashedBooks);
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $books = Book::search($searchTerm)->get();

        return response()->json($books);
    }
}
