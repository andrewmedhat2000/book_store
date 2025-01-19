<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    // Add a new author
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
        ]);

        $author = $this->authorService->createAuthor($validated);

        return response()->json([
            'message' => 'Author created successfully!',
            'author' => $author
        ], 201);
    }

    // Retrieve all authors
    public function index()
    {
        $authors = $this->authorService->getAllAuthors();
        return response()->json($authors);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'bio' => 'sometimes|required|string',
            'date_of_birth' => 'sometimes|required|date',
            'nationality' => 'sometimes|required|string|max:255',
        ]);

        $author = $this->authorService->updateAuthor($id, $validated);

        return response()->json([
            'message' => 'Author updated successfully!',
            'author' => $author
        ]);
    }

    public function destroy($id)
    {
        $this->authorService->deleteAuthor($id);

        return response()->json(['message' => 'Author deleted successfully']);
    }

    public function trashed()
    {
        $trashedAuthors = $this->authorService->getTrashedAuthors();
        return response()->json($trashedAuthors);
    }

}
