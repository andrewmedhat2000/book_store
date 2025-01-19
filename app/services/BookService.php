<?php
namespace App\Services;

use App\Models\Book;

class BookService
{
    public function createBook(array $data)
    {
        return Book::create($data);
    }

    public function getAllBooks(array $filters)
    {
        $query = Book::query();

        if (isset($filters['author_id'])) {
            $query->where('author_id', $filters['author_id']);
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->with(['author', 'category'])->get();
    }

    public function getBookById($id)
    {
        return Book::with(['author', 'category'])->findOrFail($id);
    }

    public function updateBook($id, array $data)
    {
        $book = Book::findOrFail($id);
        $book->update($data);

        return $book;
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }

    public function getTrashedBooks()
    {
        return Book::onlyTrashed()->get();
    }
}
