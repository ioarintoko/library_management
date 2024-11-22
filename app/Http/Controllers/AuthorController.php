<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Response;use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    //
    public function show($id)
    {
        // Fetch the book by ID or return a 404 if not found
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'author not found'], Response::HTTP_NOT_FOUND);
        }

        // Return the author resource
        return new AuthorResource($author);
    }

    public function getBooks($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'author not found'], Response::HTTP_NOT_FOUND);
        } else {
            $books = $author->books;
            
            if (!$books) {
                return response()->json(['message' => 'books not found'], Response::HTTP_NOT_FOUND);
            }
    
            // Return the books resource
            return new AuthorResource($books);
        }
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

        // Return a success response with updated author data
        return response()->json([
            'message' => 'Author updated successfully',
            'author' => $author,
        ], 200);
    }

    public function destroy($id)
    {
        // Find the author by ID
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => 'Author not found',
            ], 404);
        }

        // Delete the author
        $author->delete();

        // Return a success response
        return response()->json([
            'message' => 'Author deleted successfully',
        ], 200);
    }
}
