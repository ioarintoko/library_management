<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class AuthorController extends Controller
{
    public function show($id)
    {
        // Check if the author data is cached
        $author = Cache::remember("author_{$id}", 60, function () use ($id) {
            return Author::find($id);
        });

        if (!$author) {
            return response()->json(['message' => 'author not found'], Response::HTTP_NOT_FOUND);
        }

        // Return the author resource
        return new AuthorResource($author);
    }

    public function getBooks($id)
    {
        // Check if the books by author are cached
        $books = Cache::remember("author_{$id}_books", 60, function () use ($id) {
            $author = Author::with('books')->find($id);
            return $author ? $author->books : null;
        });

        if (!$books) {
            return response()->json(['message' => 'books not found'], Response::HTTP_NOT_FOUND);
        }

        // Return the books resource
        return response()->json($books);
    }

    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'required|string|max:255',
            'birthdate' => 'required|date|before:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // Unprocessable Entity
        }

        // Create a new author
        $author = Author::create([
            'name' => $request->input('name'),
            'bio' => $request->input('bio'),
            'birthdate' => $request->input('birthdate'),
        ]);

        // Clear cache for authors
        Cache::forget('authors_list');

        return response()->json([
            'message' => 'Author created successfully',
            'author' => $author,
        ], 201); // Created
    }

    public function update(Request $request, $id)
    {
        // Validate the input fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string|max:255',
            'birthdate' => 'required|date',
        ]);

        // Find the author by ID
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => 'Author not found',
            ], 404);
        }

        // Update the author details
        $author->update($validated);

        // Clear cache for this author
        Cache::forget("author_{$id}");

        // Return a success response with updated author data
        return response()->json([
            'message' => 'Author updated successfully',
            'author' => $author,
        ], 200);
    }

public function destroy($id)
{
    // Check if the author is in cache
    $cachedAuthor = Cache::get("author_{$id}");

    // If found in cache, delete it first
    if ($cachedAuthor) {
        Cache::forget("author_{$id}");
    }

    // Find the author by ID
    $author = Author::find($id);

    if (!$author) {
        return response()->json([
            'message' => 'Author not found',
        ], 404);
    }

    // Delete the author
    $author->delete();

    // Clear cache for this author
    Cache::forget("author_{$id}");

    // Return a success response
    return response()->json([
        'message' => 'Author deleted successfully',
    ], 200);
}

}
