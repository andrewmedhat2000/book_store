<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function createAuthor(array $data)
    {
        return Author::create($data);
    }

    public function getAllAuthors()
    {
        return Author::all();
    }

    public function updateAuthor($id, array $data)
    {
        $author = Author::findOrFail($id);
        $author->update($data);

        return $author;
    }

    public function deleteAuthor($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
    }

    public function getTrashedAuthors()
    {
        return Author::onlyTrashed()->get();
    }
}
