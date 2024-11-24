<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_created_with_valid_attributes()
    {
        // Arrange
        $author = Author::factory()->create();

        $attributes = [
            'title' => 'Sample Book Title',
            'description' => 'This is a test book description.',
            'publishdate' => '2024-01-01',
            'authorid' => $author->id,
        ];

        // Act
        $book = Book::create($attributes);

        // Assert
        $this->assertDatabaseHas('books', $attributes);
        $this->assertEquals($attributes['title'], $book->title);
        $this->assertEquals($attributes['description'], $book->description);
        $this->assertEquals($attributes['publishdate'], $book->publishdate);
        $this->assertEquals($attributes['authorid'], $book->authorid);
    }

    /** @test */
    public function a_book_belongs_to_an_author()
    {
        // Arrange
        $author = Author::factory()->create();
        $book = Book::factory()->create(['authorid' => $author->id]);

        // Act
        $bookAuthor = $book->author;

        // Assert
        $this->assertNotNull($bookAuthor);
        $this->assertEquals($author->id, $bookAuthor->id);
        $this->assertEquals($author->name, $bookAuthor->name);
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        // Arrange
        $author = Author::factory()->create();
        $book = Book::factory()->create(['authorid' => $author->id]);

        $updatedAttributes = [
            'title' => 'Updated Book Title',
            'description' => 'Updated book description.',
            'publishdate' => '2024-02-01',
        ];

        // Act
        $book->update($updatedAttributes);

        // Assert
        $this->assertDatabaseHas('books', $updatedAttributes);
        $this->assertEquals($updatedAttributes['title'], $book->title);
        $this->assertEquals($updatedAttributes['description'], $book->description);
        $this->assertEquals($updatedAttributes['publishdate'], $book->publishdate);
    }

    /** @test */
public function a_book_can_be_deleted()
{
    // Arrange
    $author = Author::factory()->create();
    $book = Book::factory()->create(['authorid' => $author->id]);

    // Act
    $bookId = $book->id;
    $book->delete();

    // Assert
    $this->assertDatabaseMissing('books', ['id' => $bookId]); // Check that the book is no longer in the database
}


     /** @test */
     public function a_book_cannot_be_created_with_invalid_attributes()
     {
         // Arrange: Invalid attributes
         $attributes = [
             'title' => '', // Invalid
             'authorid' => null, // Invalid
         ];
 
         // Act
         $response = $this->json('POST', route('books.store'), $attributes);
 
         // Assert
         $response->assertStatus(422); // Validation error
         $response->assertJsonValidationErrors(['title', 'authorid']);
     }
 }