<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Response;

class BookController extends Controller
{
    //
    public function show($id)
    {
        // Fetch the book by ID or return a 404 if not found
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        // Return the book resource
        return new BookResource($book);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'publishdate' => 'required|date',
            'authorid' => 'required|exists:authors,id',
        ]);

        // Create the book
        $book = Book::create($validated);

        // Return a response
        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'publishdate' => 'sometimes|date',
            'authorid' => 'sometimes|exists:authors,id',
        ]);

        // Find the book by ID
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }

        // Update the book with validated data
        $book->update($validated);

        // Return a response
        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book,
        ], 200);
    }

    public function destroy($id)
    {
        // Find the book by ID
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }

        // Delete the book
        $book->delete();

        // Return a success response
        return response()->json([
            'message' => 'Book deleted successfully',
        ], 200);
    }
}
